<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HelperFunctions
 *
 * @author matt
 */
class HelperFunctions {
    
    public function test_array_similarity($a, $b) {
        //if indexes dont match, false
        if (count(array_diff_assoc($a, $b))) {
            return false;
        }
        //indexes match, check values
        foreach ($a as $k => $v) {
            if ($v !== $b[$k]) {
                return false;
            }
        }
        //identical indexes and values
        return true;
    }
}

?>
