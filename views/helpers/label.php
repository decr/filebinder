<?php
class LabelHelper extends AppHelper {

    var $helpers = array('Html', 'Session');

    /**
     * image
     *
     * @param $file
     * @return
     */
    function image($file = null, $options = array()){
        $filePath = empty($file['file_path']) ? (empty($file['tmp_bind_path']) ? false : $file['tmp_bind_path']) : $file['file_path'];
        if (!$filePath || !preg_match('#' . WWW_ROOT . '#', $filePath)) {
            return empty($options['noImage']) ? '' : $options['noImage'];
        }
        $src = preg_replace('#' . WWW_ROOT . '#', '../', $filePath);
        unset($options['noImage']);
        return $this->Html->image($src, $options);
    }

    /**
     * link
     *
     * $param $file
     * @return
     */
    function link($file = null, $options = array()){
        $hash = $this->Session->read('Filebinder.hash');
        $filePath = empty($file['file_path']) ? (empty($file['tmp_bind_path']) ? false : $file['tmp_bind_path']) : $file['file_path'];
        if (!$filePath || !preg_match('#' . WWW_ROOT . '#', $filePath)) {
            return $this->Html->link($file['file_name'], array('admin' => false,
                                                               'plugin' => 'filebinder',
                                                               'controller' => 'filebinder',
                                                               'action' => 'loader',
                                                               $file['model'],
                                                               $file['model_id'],
                                                               $file['field_name'],
                                                               Security::hash($file['model'] . $file['model_id'] . $file['field_name'] . $hash),
                                                               $file['file_name']));
        }
        $src = preg_replace('#' . WWW_ROOT . '#', '../', $filePath);
        return $this->Html->link($file['file_name'], $src);
    }

  }