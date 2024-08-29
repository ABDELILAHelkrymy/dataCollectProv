<?php

namespace services;

use Exception;

class HabFilerException extends Exception
{
}

class HabFiler
{
    public static function getHealthyName($name)
    {
        return preg_replace('/[^\w\.]/', '-', $name);
    }

    public static function getUploadPath($name)
    {
        if (!is_dir(APP_ROOT . '/uploads')) {
            mkdir(APP_ROOT . '/uploads', 0777, true);
        }
        return '/uploads/' . $name;
    }

    public static function uploadFile($file, $name)
    {
        $time = time();
        $uploadFileName = self::getHealthyName($time . "_" . $name . '_' . $file['name']);
        $uploadFilePath = self::getUploadPath($uploadFileName);
        move_uploaded_file($file['tmp_name'], APP_ROOT . $uploadFilePath);
        return $uploadFilePath;
    }

    public static function uploadMaterielCsvFile($file)
    {
        $materiels = [];
        $time = time();
        $uploadFileName = self::getHealthyName($time . "_" . $file['name']);
        $uploadFilePath = self::getUploadPath($uploadFileName);
        move_uploaded_file($file['tmp_name'], APP_ROOT . $uploadFilePath);

        $csv = array_map('str_getcsv', file(APP_ROOT . $uploadFilePath));
        $keys = array_shift($csv);
        foreach ($csv as $i => $row) {
            $materiel = [];
            foreach ($keys as $j => $key) {
                $materiel[$key] = $row[$j];
            }
            $materiels[] = $materiel;
        }

        return $materiels;
    }
}
