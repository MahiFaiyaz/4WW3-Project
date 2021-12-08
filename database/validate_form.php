<?php
    // Simple function to check if a field submitted with POST is set and is not empty, otherwise adds to the 
    // erros array which can then be checked to see if there are errors
    function validateField(&$errors, $filed_name) {
        if ((isset($_POST[$filed_name])) && (!empty($_POST[$filed_name])) ) {
            return true;
        } else {
            $errors[$filed_name] = 'Required';
        }
    }    
?>