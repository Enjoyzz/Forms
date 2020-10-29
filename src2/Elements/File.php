<?php

declare(strict_types=1);

namespace Enjoys\Forms2\Elements;

/**
 * Description of File
 *
 * @author deadl
 */
class File extends \Enjoys\Forms2\Element
{

    private string $type = 'file';
    protected $needParent = true;

    public function __construct(string $name, string $title = null)
    {
        parent::__construct($name, $title);
//        $this->addRule(Rules::UPLOAD, null, [
//            'system'
//        ]);
        //  parent::setAttribute('method', 'dddd');
        //$this->setMaxFileSize(self::phpIniSize2bytes(ini_get('upload_max_filesize')), false);
    }

    public function prepare()
    {
        $this->getParent()->setAttributes([
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ]);
        $this->setMaxFileSize($this->phpIniSize2bytes(ini_get('upload_max_filesize')));

       // $this->unsetParent();
    }

    /**
     * 
     * @param int $bytes
     * @return $this
     */
    public function setMaxFileSize(int $bytes): self
    {
        $this->getParent()->hidden('MAX_FILE_SIZE', (string) $bytes);
        return $this;
    }

    public function render()
    {
        return "<input type=\"{$this->type}\"{$this->getAttributes()}>";
    }
    /**
     *
     * @param string $ruleName
     * @param string $message
     * @param array $params
     * @return $this
     */
//    public function addRule(string $ruleName, ?string $message = null, $params = [])
//    {
//        if (\strtolower($ruleName) !== \strtolower(Rules::UPLOAD)) {
//            throw new ExceptionRule(
//                    \sprintf("К элементу [%s] можно подключить только правило: [%s]", __CLASS__, Rules::UPLOAD)
//            );
//        }
//        return parent::addRule($ruleName, $message, $params);
//    }
////    
//    //    /**
////     * 
////     * @todo перенести в другой проект
////     */
    private function phpIniSize2bytes($size_original): int
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size_original); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size_original); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return (int) round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return (int) round($size);
        }
    }
}