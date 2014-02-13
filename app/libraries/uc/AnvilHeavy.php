<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// app/lib/Acme/Product/Anvil/AnvilInterface.php
namespace uc;

interface AnvilInterface {

    public function drop();

}

// app/lib/Acme/Product/Anvil/AnvilHeavy.php

class AnvilHeavy implements AnvilInterface {

    public function drop()
    {
        return "ouch!";
    }

}