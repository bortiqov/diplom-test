<?php

namespace common\modules\file\models;

use Yii;
use yii\base\ErrorException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use common\modules\file\rules\OwnerRule;
use common\modules\user\models\User;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string $extension
 * @property int $date_create
 * @property int $user_id
 * @property int $status
 *
 * @property User $user
 */
class File extends ActiveRecord
{
	/**
	 * @var int
	 */
	const STATUS_ACTIVE   = 2;

	/**
	 * @var int
	 */
	const STATUS_DEACTIVE = 1;

	/**
	 * @var int
	 */
	const STATUS_DELETED = 0;

	/**
	 *
	 */
	const PERMISSION_CREATE  = "FILE_CREATE";

	/**
	 *
	 */
	const PERMISSION_VIEW  = "FILE_VIEW";

	/**
	 *
	 */
	const PERMISSION_UPDATE  = "FILE_UPDATE";

	/**
	 *
	 */
	const PERMISSION_DELETE  = "FILE_DELETE";

	/**
	 *
	 */
	const PERMISSION_OWNER  = "FILE_OWNER";

	/**
	 *
	 */
	const RULE_OWNER = "RULE_OWNER";

	/**
	 * @throws \Exception
	 * @throws \yii\base\Exception
	 */
	public static function initPermessions()
	{
		$auth = Yii::$app->authManager;

		if(!($OwnerRule = $auth->getRule(self::RULE_OWNER))) {
			$OwnerRule = new OwnerRule();
			$auth->add( $OwnerRule );
		}

		if(!($OwnerPermession = $auth->getPermission(self::PERMISSION_OWNER))) {
			$OwnerPermession = $auth->createPermission( self::PERMISSION_OWNER );
			$OwnerPermession->description = 'OwnerPermession';
			$OwnerPermession->ruleName = $OwnerRule->name;
			$auth->add($OwnerPermession);
		}

		if(!($CreatePermession = $auth->getPermission(self::PERMISSION_CREATE))) {
			$CreatePermession = $auth->createPermission( self::PERMISSION_CREATE );
			$CreatePermession->description = 'CreatePermission';
			$auth->add($CreatePermession);
		}

		if(!($UpdatePermession = $auth->getPermission(self::PERMISSION_UPDATE))) {
			$UpdatePermession = $auth->createPermission( self::PERMISSION_UPDATE );
			$UpdatePermession->description = 'UpdatePermission';
			$auth->add($UpdatePermession);
			$auth->addChild($OwnerPermession, $UpdatePermession);
		}

		if(!($ViewPermession = $auth->getPermission(self::PERMISSION_VIEW))) {
			$ViewPermession = $auth->createPermission( self::PERMISSION_VIEW );
			$ViewPermession->description = 'ViewPermission';
			$auth->add($ViewPermession);
			$auth->addChild($OwnerPermession, $ViewPermession);
		}

		if(!($DeletePermession = $auth->getPermission(self::PERMISSION_DELETE))) {
			$DeletePermession = $auth->createPermission( self::PERMISSION_DELETE );
			$DeletePermession->description = 'DeletePermission';
			$auth->add($DeletePermession);
			$auth->addChild($OwnerPermession, $DeletePermession);
		}

		/**
		 * WRITER ROLE
		 */
		if(!($writer = $auth->getRole(User::ROLE_WRITER))) {
			$writer = $auth->createRole(User::ROLE_WRITER);
			$auth->add($writer);
		}
		if(!$auth->hasChild($writer, $CreatePermession)){
			$auth->addChild($writer, $CreatePermession);
		}

		if(!$auth->hasChild($writer, $OwnerPermession)){
			$auth->addChild($writer, $OwnerPermession);
		}

		if(!$auth->hasChild($writer, $ViewPermession)){
			$auth->addChild($writer, $ViewPermession);
		}

		/**
		 * EDITOR ROLE
		 */
		if(!($editor = $auth->getRole(User::ROLE_EDITOR))) {
			$editor = $auth->createRole(User::ROLE_EDITOR);
			$auth->add($editor);
		}

		if(!$auth->hasChild($editor, $writer)){
			$auth->addChild($editor, $writer);
		}

		/**
		 * MANAGER ROLE
		 */
		if(!($manager = $auth->getRole(User::ROLE_MANAGER))){
			$manager = $auth->createRole(User::ROLE_MANAGER);
			$auth->add($manager);
		}
		if(!$auth->hasChild($manager, $UpdatePermession)){
			$auth->addChild($manager, $UpdatePermession);
		}

		if(!$auth->hasChild($manager, $DeletePermession)){
			$auth->addChild($manager, $DeletePermession);
		}

		if(!$auth->hasChild($manager, $editor)){
			$auth->addChild($manager, $editor);
		}

		/**
		 * ADMIN ROLE
		 */
		if(!($admin = $auth->getRole(User::ROLE_ADMIN))){
			$admin = $auth->createRole(User::ROLE_ADMIN);
			$auth->add($admin);
		}

		if(!$auth->hasChild($admin, $manager)){
			$auth->addChild($admin, $manager);
		}
	}

	/**
	 * @return bool
	 */
	public function canCreate(){
		return \Yii::$app->user->can(self::PERMISSION_CREATE, ['file' => $this]);
	}

	/**
	 * @return bool
	 */
	public function canView(){
		return \Yii::$app->user->can(self::PERMISSION_VIEW, ['file' => $this]);
	}

	/**
	 * @return bool
	 */
	public function canUpdate(){
		return \Yii::$app->user->can(self::PERMISSION_UPDATE, ['file' => $this]);
	}

	/**
	 * @return bool
	 */
	public function canDelete(){
		return \Yii::$app->user->can(self::PERMISSION_DELETE, ['file' => $this]);
	}

	/**
	 * @var array
	 */
	public $file_data = [];

	/**
	 * @var array
	 */
	public $file_secure = false;

	/**
	 * @var array
	 */
	public $image_sizes = [
		'thumb' => [
			'title' => 'Thumbnail',
			'width' => 150,
			'height' => 150,
			'quality' => 100, //  70
			'crop' => true,
			'prefix' => 'thumb_',
			'suffix' => ''
		],
		'small' => [
			'title' => 'Small',
			'width' => 300,
			'height' => 300,
			'quality' => 100, //  70
			'prefix' => 's_',
			'suffix' => ''
		],
		'medium' => [
			'title' => 'Medium',
			'width' => 800,
			'height' => 600,
			'quality' => 100, //  70
			'prefix' => 'm_',
			'suffix' => ''
		],
		//'large' => [
		//	'title' => 'Large',
		//	'width' => 1024,
		//	'height' => 1024,
		//	'quality' => 100, //  70
		//	'prefix' => 'l_',
		//	'suffix' => ''
		//],
		'full' => [
		],
	];

	/**
	 * @var array
	 */
	private $allowed_types = [
		'image' => [
			'jpg','jpeg','png','bmp','webp','gif','jpf'
		],
		'video' => [
			'mp4','mov','mkv','ogm','webm','wmv','flv'
		],
		'audio' => [
			'mp3', 'wav', 'ogg'
		]
	];

	/**
	 * @var array
	 */
	private $ignored_extensions = [
		'php', 'js'
	];

	/**
	 * @var bool
	 */
	public $runUpload = true;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'file';
	}

	/**
	 * @return array
	 */
	public function behaviors()
	{
		return [
			'date_create' => [
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['date_create'],
				],
			],
		];

	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['user_id'], 'default', 'value' => null],
			[['status'], 'default', 'value' => 1],
			[['secure'], 'default', 'value' => 0],
			[['user_id'], 'default', 'value' => 1],
			[['user_id', 'status', 'size', 'secure'], 'integer'],
			[['file_data'], 'file'],
			[['file_secure'], 'safe'],
			[['name', 'title', 'description', 'caption', 'extension', 'mime_type'], 'string', 'max' => 255],
			[['title', 'description', 'caption'], 'filter', 'filter' => function($value){
				return strip_tags($value);
			}],
//			[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id'          => Yii::t( 'system', 'ID' ),
			'name'        => Yii::t( 'system', 'Name' ),
			'title'       => Yii::t( 'system', 'Title' ),
			'description' => Yii::t( 'system', 'Description' ),
			'caption'     => Yii::t( 'system', 'Caption' ),
			'extension'   => Yii::t( 'system', 'Extension' ),
			'date_create' => Yii::t( 'system', 'Date Create' ),
			'user_id'     => Yii::t( 'system', 'User' ),
			'status'      => Yii::t( 'system', 'Status' ),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}

	/**
	 * @return string
	 */
	public function getReadableSize()
	{
		Yii::$app->formatter->sizeFormatBase = 1000;
		return Yii::$app->formatter->asShortSize($this->size, 0);
	}

	/**
	 * @return mixed
	 */
	public function getUpload_dir()
	{
		return getenv("UPLOAD_DIR");
	}

	/**
	 * @return mixed
	 */
	public function getUpload_dir_src()
	{
		return getenv("UPLOAD_DIR_SRC");
	}

	/**
	 * @param null $image_size
	 *
	 * @return bool|string
	 */
	public function getSrc($image_size = null)
	{
		$dist = self::dist($this->upload_dir_src, $this->name, $this->extension);

		if($this->getIsImage()){
			if($image_size && array_key_exists($image_size, $this->image_sizes)) {
				return $this->getImageSrc($image_size);
			}
		}

		return $dist;
	}

	/**
	 * @param null $image_size
	 *
	 * @return bool|string
	 */
	public function getDist($image_size = null)
	{
		$dist = self::dist($this->upload_dir, $this->name, $this->extension);

		if($this->getIsImage()){
			if($image_size && array_key_exists($image_size, $this->image_sizes)) {
				return $this->getImageSrc($image_size);
			}
		}

		return $dist;
	}

	/**
	 * @param null $image_size
	 *
	 * @return bool|string
	 */
	public function getImageSrc($image_size = null)
	{
		if($this->getIsImage()){
			if($image_size && array_key_exists($image_size, $this->image_sizes)) {
				$size = $this->image_sizes[$image_size];
				$dist = self::dist($this->upload_dir, $this->name, $this->extension, $size['prefix'], $size['suffix']);
				if(file_exists($dist)){
					return self::dist($this->upload_dir_src, $this->name, $this->extension, $size['prefix'], $size['suffix']);
				}
			}
		}
		return $this->upload_dir_src . 'default.jpg';

	}

	/**
	 * @param null $image_size
	 *
	 * @return bool|string
	 */
	public function getImageDist($image_size = null)
	{
		if($this->getIsImage()){
			if($image_size && array_key_exists($image_size, $this->image_sizes)) {
				$size = $this->image_sizes[$image_size];
				$dist = self::dist($this->upload_dir, $this->name, $this->extension, $size['prefix'], $size['suffix']);
				if(file_exists($dist)){
					return $dist;
				}
			}
		}
		return false;
	}

	/**
	 * @param int $length
	 *
	 * @return string
	 */
	public static function generateRandomName($length = 32)
	{
		$availableCharacters = [
			'A','B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
			'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h','i', 'j', 'k', 'l','m',
			'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
			'0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
		];

		$random_name = "";

		for($i = 0; $i < $length; $i++){
			$random_name .= $availableCharacters[rand(0, (sizeof($availableCharacters)-1))];
		}

		return $random_name;
	}

	/**
	 *
	 */
	public function uploadFile()
	{
		$file_random_name = static::generateRandomName();
		$file_data = self::parse($file_random_name);

        $file_folder = $file_data['folder'];

        $this->name      = $file_random_name;
		$this->title     = $this->file_data->baseName;
		$this->extension = $this->file_data->extension;
		$this->mime_type = FileHelper::getMimeType($this->file_data->tempName);
		$this->size      = $this->file_data->size;

		if($this->file_secure)
			$this->secure = 1;

		if(!$this->validate())
			return false;

		$upload_dir = Yii::getAlias($this->upload_dir . $file_folder);
		FileHelper::createDirectory($upload_dir, 0777);

		$file_src = self::dist($this->upload_dir, $file_random_name, $this->extension);
		if(!$this->file_data->saveAs($file_src)) {
			return false;
		}

		//copy($this->file_data->tempName, $file_src);

		if (in_array($this->extension, $this->allowed_types['image'])) {
			$this->createThumbs($this->upload_dir, $file_random_name, $this->extension);
			FileHelper::unlink($file_src);
		}

		return true;
	}

	/**
	 * @param $file_dir
	 * @param $file_name
	 * @param $file_ext
	 */
	public function createThumbs( $file_dir, $file_name, $file_ext)
	{
		$file_src = self::dist($file_dir, $file_name, $file_ext);

		foreach ($this->image_sizes as $image){

			$width   = $image['width'];
			$height  = $image['height'];
			$quality = $image['quality'];
			$crop    = $image['crop'];
			$prefix  = $image['prefix'];
			$suffix  = $image['suffix'];

			$file_new_src = self::dist($file_dir, $file_name, $file_ext, $prefix, $suffix);

			if(file_exists($file_new_src))
				continue;

			$this->createThumb($file_src, $width, $height, $file_new_src, $crop, $quality);

		}
	}

	/**
	 * @param $file_src
	 * @param $width
	 * @param $height
	 * @param $file_new_src
	 * @param $quality
	 */
	public function createThumb($file_src, $width, $height = null, $file_new_src, $crop, $quality = 80)
	{
		$height = $crop === true ? $height : null;

		Image::thumbnail($file_src, $width, $height)->save($file_new_src, ['quality' => $quality]);
	}

	/**
	 * @param $dir
	 * @param $filename
	 *
	 * @return bool|string
	 */
	public static function dist($dir_src, $name, $ext = null, $prefix = null, $suffix = null)
	{
		$data = self::parse($name);
		return Yii::getAlias($dir_src . $data['folder'] . "/" . $prefix . $data['file'] . $suffix . "." . $ext);
	}

	/**
	 * @return array
	 */
	public function getImageInfo()
	{
		$sizes = [];
		if($this->getIsImage()){
//			$dist = self::dist($this->upload_dir, $this->name, $this->extension);
//			if(!file_exists($dist)){
//				return [];
//			}
//			$image = Image::getImagine()->open(Yii::getAlias($dist));
//			$image_size = $image->getSize();
//			$sizes['full'] = [
//				'title' => Yii::t('system', 'Full'),
//				'width' => $image_size->getWidth(),
//				'height' => $image_size->getHeight(),
//				'link' => $this->getDist()
//			];
            foreach($this->image_sizes as $key => $size){
                $dist = self::dist($this->upload_dir, $this->name, $this->extension, $size['prefix'], $size['suffix']);
                if(!file_exists($dist)){
                    continue;
                }
                $image = Image::getImagine()->open(Yii::getAlias($dist));
                $image_size = $image->getSize();
                $sizes[$key] = [
                    'title' => Yii::t('system', $size['title']),
                    'width' => $image_size->getWidth(),
                    'height' => $image_size->getHeight(),
                    'link' => $this->getDist($key)
                ];
            }
		} else {
			$sizes['full'] = [
				'title' => Yii::t('system', 'Full'),
				'link' => $this->getDist()
			];
		}
		return $sizes;
	}

	/**
	 * @param null $filename
	 *
	 * @return array
	 */
	public static function parse($filename = null)
	{
		$folder = mb_substr($filename,0, 2);
		$file = mb_substr($filename, 2);

		return [
			'file'   => $file,
			'folder' => $folder
		];
	}

	/**
	 * @return bool
	 */
	public function getIsImage()
	{
		return ArrayHelper::isIn($this->extension, $this->allowed_types['image']);
	}

	/**
	 * @return bool
	 */
	public function getIsAudio()
	{
		return ArrayHelper::isIn($this->extension, $this->allowed_types['audio']);
	}

	/**
	 * @return array
	 */
	public function getAllowedTypes()
	{
		return $this->allowed_types;
	}

	/**
	 * @return array
	 */
	public function getThumbnails()
	{
		$images = [
			'full' => $this->getImageSrc()
		];
		foreach($this->image_sizes as $key => $image_size){
			$images[$key] = $this->getImageSrc($key);
		}
		return $images;
	}

	/**
	 * @return array
	 */
	public function getExtension()
	{
		return $this->extension;
	}

	/**
	 * @param bool $insert
	 *
	 * @return bool
	 */
	public function beforeSave($insert)
	{
		parent::beforeSave($insert);
		//
		if($this->runUpload && $insert)
			return $this->uploadFile();

		return true;
	}

	/**
	 * @return bool
	 */
	//public function beforeDelete()
	//{
	//	$this->updateAttributes(['status' => self::STATUS_DELETED]);
	//	return false;
	//}

	/**
	 *
	 */
	public function afterDelete()
	{
		//FileHelper::unlink(self::dist($this->upload_dir, $this->name, $this->extension));
		//
		//if(in_array($this->extension, $this->allowed_types['image'])){
		//	foreach($this->image_sizes as $image){
		//		$dist = self::dist($this->upload_dir, $this->name, $this->extension, $image['prefix'], $image['suffix']);
		//		FileHelper::unlink(($dist));
		//	}
		//}
	}

	public function deleteFile()
	{
		if(file_exists($this->getDist())){
			$this->delete();
			FileHelper::unlink($this->getDist());
		}

		if($this->getIsImage()){
			foreach($this->image_sizes as $key => $size){
				if($this->getImageDist($key) && file_exists($this->getImageDist($key))){
					$this->delete();
					FileHelper::unlink($this->getImageDist($key));
				}
			}
		}
	}

	/**
	 * @return \common\modules\file\models\FilesQuery|\yii\db\ActiveQuery
	 */
	public static function find()
	{
		return new FilesQuery(get_called_class());
	}

	/**
	 * @return array
	 */
	public function fields()
	{
		return [
			'title',
			'description',
			'thumbnails'
		];
	}
}
