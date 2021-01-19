<?php
require_once '../../classes/Show.php';
require_once '../../classes/Stage.php';
require_once '../../classes/Performer.php';
require_once '../../classes/Gump.php';
require_once '../../utils/functions.php';

try {
    $validator = new GUMP();

    $_POST = $validator->sanitize($_POST);

    $validation_rules = array(
        'performer_id' => 'required|integer|min_numeric,1',
        'stage_id' => 'required|integer|min_numeric,1',
        'start_time' => 'required',
        'end_time' => 'required'
    );
    $filter_rules = array(
        'stage_id' => 'trim|sanitize_numbers',
        'performer_id' => 'trim|sanitize_numbers'
    );

    $validator->validation_rules($validation_rules);
    $validator->filter_rules($filter_rules);

    $validated_data = $validator->run($_POST);
    
    $fileName = time();

    if($validated_data === false) {
        $errors = $validator->get_errors_array();
    }
    else {
        $errors = array();
        
        $performer_id = $validated_data['performer_id'];
        $stage_id = $validated_data['stage_id'];
        $performer = Performer::find($performer_id);
        $stage = Stage::find($stage_id);
        if ($performer === false) {
            $errors['performer_id'] = "Invalid performer";
        }
        if ($stage === false) {
            $errors['stage_id'] = "Invalid stage";
        }
    }

    if (!empty($errors)) {
        throw new Exception("There were errors. Please fix them.");
    }

    $show = new Show();
    $show->start_time = $validated_data['start_time'];
    $show->end_time = $validated_data['end_time'];
    $show->performer_id = $validated_data['performer_id'];
    $show->stage_id = $validated_data['stage_id'];

    $show->save();

    header("Location: index.php");
}
catch (Exception $ex) {
    require 'create.php';
}
?>
