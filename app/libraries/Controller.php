<?php

//This is the main  controller in our mvc model - this loads models and views

class Controller{

//Load Model
    public function model($model){
        require_once '../app/models/'. $model. '.php';
        
        return new $model();
    }
//Load View
    public function view($view, $data = []){
        //check for the view
        if(file_exists('../app/views/'.$view . '.php')){

            require_once '../app/views/' . $view . '.php';
        } else{
            die("view does not exist");
        }

    }
    //Load View for Feeds
    public function viewFeed($view, $data1, $data2, $postFlash=NULL){
        //check for the view
        if(file_exists('../app/views/'.$view . '.php')){

            require_once '../app/views/' . $view . '.php';
        } else{
            die("view does not exist");
        }

    }
    //Load View for Feed
    public function viewProfile($view, $data, $profileInformation, $profileFlash=NULL){
        //check for the view
        if(file_exists('../app/views/'.$view . '.php')){

            require_once '../app/views/' . $view . '.php';
        } else{
            die("view does not exist");
        }

    }
   
}