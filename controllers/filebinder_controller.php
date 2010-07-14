<?php
class FilebinderController extends FilebinderAppController {

    var $name = 'Filebinder';
    var $uses = array();
    var $components = array('Session');

    /**
     * loader
     * file loader
     *
     * @param string $model
     * @param string $model_id
     * @param string $fieldName
     * @param string $hash
     * @return
     */
    function loader($model = null, $model_id = null, $fieldName = null, $hash = null){
        $this->layout = false;
        $this->autoRender = false;
        Configure::write('debug', 0);

        if (!$model || !$model_id || !$fieldName || !$hash) {
            return;
        }
        if (Security::hash($model . $model_id . $fieldName . $this->Session->read('Filebinder.hash')) !== $hash) {
            return;
        }

        $this->loadModel($model);

        $query = array();
        $query['recursive'] = -1;
        $query['fields'] = array('id',
                                 $fieldName);
        $query['conditions'] = array('id' => $model_id);
        $file = $this->{$model}->find('first', $query);

        $fileName = $file[$model][$fieldName]['file_name'];
        $fileContentType = $file[$model][$fieldName]['file_content_type'];
        $filePath = $file[$model][$fieldName]['file_path'];

        header('Content-Disposition: attachment; filename="'. $fileName .'"');
        header('Content-Length: '. filesize($filePath));
        header('Content-Type: application/octet-stream');
        readfile($filePath);
    }

  }
