<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30.10.15
 * Time: 12:18
 */
namespace Files;


use Bluz\Http\File;

class Manager
{

    /**
     * @var File
     */
    protected $file;


    /**
     * @var
     */
    protected $uploadPath;


    /**
     * Manager constructor.
     * @param File $file
     * @param      $newPath
     */
    public function __construct(File $file, $newPath)
    {
        $this->file = $file;
        $this->uploadPath = $newPath;
    }


    /**
     * @throws \Bluz\Request\RequestException
     */
    public function renameFileName()
    {

        $fileName = strtolower($this->file->getName());
        // Prepare filename
        $fileName = preg_replace('/[ _;:]+/i', '-', $fileName);
        $fileName = preg_replace('/[-]+/i', '-', $fileName);
        $fileName = preg_replace('/[^a-z0-9.-]+/i', '', $fileName);

        // If name is wrong
        if (empty($fileName)) {
            $fileName = date('Y-m-d-His');
        }

        // If file already exists, increment name
        $originFileName = $fileName;
        $counter = 0;
        while (file_exists($this->uploadPath . $fileName . '.' . $this->file->getExtension())) {
            $counter++;
            $fileName = $originFileName . '-' . $counter;
        }
        // Setup new name and move to user directory
        $this->file->setName($fileName);
        $this->file->moveTo($this->uploadPath);


    }


    /***
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }


}