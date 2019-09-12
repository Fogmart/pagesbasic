<?php

namespace app\models;

use rmrevin\yii\module\Comments\interfaces\CommentatorInterface;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface, CommentatorInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    const USER_STATUSES = ['9' => 'Не активен', '10' => 'Активен'];

    public $groups_arr;
    public $groups_read;
    public $groups_edit;
    public $groups_comment;

    public $canadmin;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['email'], 'required'],
            [['email'], 'unique'],
            [['username'], 'string', 'max' => 250],
            [['email'], 'string', 'max' => 255],
            [['lname', 'fname', 'mname'], 'string', 'max' => 30],
            [['role'], 'string', 'max' => 50],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['groups_arr'], 'safe'],
            [['groups_read'], 'safe'],
            [['groups_edit'], 'safe'],
            [['groups_comment'], 'safe'],
            [['canadmin'], 'safe'],
            [['homepageid'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'groups_arr' => 'Группы',
            'canadmin' => 'Администратор',
            'lname' => 'Фамилия',
            'fname' => 'Имя',
            'mname' => 'Отчество',
            'role' => 'Должность и судно',
            'homepageid' => 'Домашняя страница',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**********************************/
    public function afterFind()
    {
        parent::afterFind();
        $this->groups_arr = $this->groups;
        $this->canadmin = Yii::$app->authManager->checkAccess($this->id, 'admin');

    }

    public function afterSave($insert, $changedAttributes)
    {
        $userRole = Yii::$app->authManager->getRole('admin');
        if ($this->canadmin) {
            if (!Yii::$app->authManager->checkAccess($this->id, 'admin'))
                Yii::$app->authManager->assign($userRole, $this->id);
        } else {
            if (Yii::$app->authManager->checkAccess($this->id, 'admin'))
                Yii::$app->authManager->revoke($userRole, $this->id);
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    public function getUserGroup()
    {
        return $this->hasMany(UserGroup::className(), ['user_id' => 'id']);
    }

    public function getGroups()
    {
        return $this->hasMany(Group::className(), ['id' => 'group_id'])->via('userGroup');
    }

//
    public function getPages()
    {
        $result = [];
        foreach ($this->groups as $one) {
            foreach ($one->cats as $cat) {
                foreach ($cat->pages as $p)
                $result[] = $p;
            }
        }
        return $result;
    }

    public function getPageids(){
        $result = [];
        foreach ($this->pages as $page){
            $result[] = $page->id;
        }
        return $result;
    }

    public function getCatIds(){
        $result = [];
        if (!$this->canadmin) {
            foreach ($this->groups as $one)
                foreach ($one->cats as $cat)
                    $result[] = $cat->id;
        } else {
            foreach (Category::find()->all() as $cat)
                $result[] = $cat->id;
        }
        return $result;
    }
    public function getCatphpIds(){
        $result = [];
        if (!$this->canadmin) {
            foreach ($this->groups as $one)
                foreach ($one->catsphp as $cat)
                    $result[] = $cat->id;
        } else {
            foreach (CategoriesPhp::find()->all() as $cat)
                $result[] = $cat->id;
        }
        return $result;
    }


    public function getIsUserGroup($group_id)
    {
        if (UserGroup::findOne(["group_id" => $group_id, "user_id" => $this->id])) {
            return true;
        } else {
            return false;
        }
    }

    public function getIsUserGroupEdt($group_id)
    {
        $ug = UserGroup::findOne(["group_id" => $group_id, "user_id" => $this->id]);
        if ($ug->can_edit == 1) {
            return true;
        } else {
            return false;
        }
    }


    public function getMenuItems()
    {
        $groups = Group::find()->all();
        $items = [];
        foreach ($groups as $group) {
            if ($group->parid == null) {
                $itm = $this->setItem($group);
                if ($itm != []) $items[] = $itm;

            }
        }

        return $items;
    }

    public function getDownLvl($group)
    {
        $items = [];
        foreach ($group->child as $dm) {
            $itm = $this->setItem($dm);
            if ($itm != []) $items[] = $itm;
        }

        return $items;
    }

    public function setItem($group)
    {

        if ($this->getIsUserGroup($group->id)) {
            $itm = [
                "label" => $group->name,
                "url" => ["/page/bygroup/", 'groupid' => $group->id],
                'items' => $this->getDownLvl($group),
            ];
        } else {
            $itm = $this->getDownLvl($group);
        }
        if (is_array($itm)) if (count($itm) == 1) $itm = $itm[0];
        return $itm;

    }


    public function saveGroups($read, $edit, $comment)
    {
        UserGroup::deleteAll(['user_id' => $this->id]);
        foreach ($read as $r) {
            $model = new UserGroup();
            $model->group_id = $r;
            $model->user_id = $this->id;
            $model->can_read = 1;
            if (in_array($r, $edit)) $model->can_edit = 1;
            if (in_array($r, $comment)) $model->can_comment = 1;
            $model->save();
        }
    }

    public function getReadGroups()
    {
        $res = [];
        foreach ($this->userGroup as $gr) {
            if ($gr->can_read == 1) $res[] = $gr->group_id;
        }
        return $res;
    }

    public function getEditGroups()
    {
        $res = [];
        foreach ($this->userGroup as $gr) {
            if ($gr->can_edit == 1) $res[] = $gr->group_id;
        }
        return $res;
    }

    public function getEditCats()
    {
        $res = [];

        foreach ($this->groups as $gr) {
            $res = array_merge($gr->catsEditIds, $res);
        }
        return $res;
    }


    public function getCommentGroups()
    {
        $res = [];
        foreach ($this->userGroup as $gr) {
            if ($gr->can_comment == 1) $res[] = $gr->group_id;
        }
        return $res;
    }

    public function getCommentatorAvatar()
    {
        return false;
    }

    public function getCommentatorName()
    {
        return $this->lname.' '.$this->fname.' '.$this->mname.', '.$this->role;
    }

    public function getCommentatorUrl()
    {
        return false;
    }

    public function getName()
    {
        return $this->username;
    }

    public function getHomePageUrl(){
        $hpid = ($this->homepageid)? $this->homepageid : Options::findOne(1)->homeurl;
        return PagesLk::findOne($hpid)->url;
    }

}
