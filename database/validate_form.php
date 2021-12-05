<?php
    function validateField(&$errors, $filed_name) {
        if ( (isset($_POST[$filed_name])) && (!empty($_POST[$filed_name])) ) {
            return true;
        } else {
            $errors[$filed_name] = 'Required';
        }
    }    
?>