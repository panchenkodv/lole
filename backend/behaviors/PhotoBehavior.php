<?php

namespace backend\behaviors;

use yii\base\Behavior;
use yii\base\ErrorException;
use yii\base\InvalidArgumentException;
use yii\web\UploadedFile;

/**
 * @property string $photoAttribute
 * @property string $storePath
 * @property string $tmpDir
 */
class PhotoBehavior extends Behavior
{
    /** @var string $photoAttribute -- attribute for store photos in array */
    public $photoAttribute = 'aPhotos';

    /** @var string $storePath -- path to store saved photos */
    public $storePath = 'store/images/default';

    /** @var string $tmpDir -- path to store temporary files if model not set*/
    private $tmpDir = 'tmp';

    const ACCESS_MODE = 0755;

    public function init()
    {
        if (!file_exists($this->storePath)) {
            @mkdir($this->storePath, self::ACCESS_MODE, true);
        }

        if (!is_writable($this->storePath)) {
            throw new ErrorException("Path `{$this->storePath}` not writable.");
        }

        if (!file_exists("{$this->storePath}/{$this->tmpDir}")) {
            @mkdir("{$this->storePath}/{$this->tmpDir}", self::ACCESS_MODE, true);
        }

        if (!is_writable("{$this->storePath}/{$this->tmpDir}")) {
            throw new ErrorException("Path `{$this->storePath}/{$this->tmpDir}` not writable.");
        }

        parent::init();
    }

    /**
     * Add photo to model
     * @param UploadedFile $file
     * @return bool
     */
    public function addPhoto(UploadedFile $file): bool
    {
        $fileName = self::getName();
        if ($this->owner->canSetProperty($this->photoAttribute)
            && $file->saveAs("{$this->storePath}/{$fileName}.{$file->extension}")
        ) {
            array_push($this->owner->{$this->photoAttribute}, "{$fileName}.{$file->extension}");
            return $this->owner->save();
        }

        return false;
    }

    public function deletePhoto()
    {

    }

    public function orderPhoto()
    {

    }

    /**
     * Add photo to session and save it to temp directory
     * @param UploadedFile $file
     * @return bool
     */
    public function saveFileToTmpFolder(UploadedFile $file, $uniqueId = null): bool
    {
        if ($uniqueId === null) {
            throw new InvalidArgumentException(\Yii::t('photoBehavior', 'You must specify `uniqueId` '));
        }
        $file->saveAs("{$this->storePath}/{$this->tmpDir}/{$this->getName()}.{$file->extension}");
        return true;
    }

    /**
     * Function for generating unique file name
     * @return string
     */
    private function getName(): string
    {
        return uniqid('', true);
    }
}
