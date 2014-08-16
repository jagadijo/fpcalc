<?php

function btn_add ($uri, $label = '')
{
   return anchor($uri, '<span class="glyphicon glyphicon-plus"></span> ' . $label, 
      array(
         'type' => 'button',
         'class' => 'btn btn-default',
         'title' => 'Add'
      ));
}

function btn_detail ($uri, $label = '')
{
   return anchor($uri, '<span class="glyphicon glyphicon-book"></span> ' . $label, 
      array(
         'type' => 'button',
         'class' => 'btn btn-default btn-xs',
         'title' => 'Detail'
      ));
}

function btn_edit ($uri, $label = '')
{
   return anchor($uri, '<span class="glyphicon glyphicon-edit"></span> ' . $label, 
      array(
         'type' => 'button',
         'class' => 'btn btn-default btn-xs',
         'title' => 'Edit'
      ));
}

function btn_delete ($uri, $label = '')
{
   return anchor($uri, '<span class="glyphicon glyphicon-trash"></span> ' . $label, 
      array(
         'onclick' => "return confirm('You are about to delete a record. This cannot be undone. Are you sure?');",
         'type' => 'button',
         'class' => 'btn btn-default btn-xs',
         'title' => 'Delete'
      ));
}