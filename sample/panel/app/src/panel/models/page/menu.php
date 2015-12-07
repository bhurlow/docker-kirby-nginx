<?php 

namespace Kirby\Panel\Models\Page;

use Exception;
use Brick;

class Menu {

  public $page;
  public $parent;
  public $blueprint;
  public $position;

  public function __construct($page, $position = 'sidebar') {
    $this->page      = $page;
    $this->parent    = $page->parent();
    $this->blueprint = $page->blueprint();
    $this->position  = $position;
  }

  public function item($icon, $label, $attr = array()) {

    $a = new Brick('a', '', $attr);
    $a->append(icon($icon, 'left'));
    $a->append(l($label));

    $li = new Brick('li');
    $li->append($a);

    return $li;

  }

  public function modalUrl($action) {

    if($this->position == 'context') {    
      if($this->parent->isSite()) {
        $redirect = '/';
      } else {
        $redirect = $this->parent->uri('edit');        
      }
      return $this->page->url($action) . '?_redirect=' . $redirect;
    } else {
      return $this->page->url($action);
    }

  }

  public function previewOption() {  
    if($preview = $this->page->url('preview')) {
      return $this->item('play-circle-o', 'pages.show.preview', array(
        'href'          => $preview,
        'target'        => '_blank',
        'title'         => 'p',
        'data-shortcut' => 'p',
      ));
    } else {
      return false;
    }
  }

  public function editOption() {  
    if($this->position == 'context') {
      return $this->item('pencil', 'pages.show.subpages.edit', array(
        'href' => $this->page->url('edit'),
      ));      
    }
  }

  public function statusOption() {

    if(!$this->page->isErrorPage()) {

      if($this->page->isInvisible()) {
        $icon  = 'toggle-off';
        $label = 'pages.show.invisible';
      } else {
        $icon  = 'toggle-on';
        $label = 'pages.show.visible';      
      }

      return $this->item($icon, $label, array(
        'href'       => $this->modalUrl('toggle'),
        'data-modal' => true,
      ));

    } else {
      return false;
    }


  } 

  public function urlOption() {
    if(!$this->page->isHomePage() and !$this->page->isErrorPage()) {
      return $this->item('chain', 'pages.show.changeurl', array(
        'href'          => $this->modalUrl('url'),
        'title'         => 'u',
        'data-shortcut' => 'u',
        'data-modal'    => true,
      ));      
    } else {
      return false;
    }
  }

  public function deleteOption() {
    if($this->page->isDeletable()) {
      return $this->item('trash-o', 'pages.show.delete', array(
        'href'          => $this->modalUrl('delete'),
        'title'         => '#',
        'data-shortcut' => '#',
        'data-modal'    => true,
      ));
    } else {
      return false;
    }
  }

  public function html() {

    $list = new Brick('ul');
    $list->addClass('nav nav-list');

    if($this->position == 'sidebar') {
      $list->addClass('sidebar-list');
    } else {
      $list->addClass('dropdown-list');
    }

    $list->append($this->previewOption());
    $list->append($this->editOption());
    $list->append($this->statusOption());
    $list->append($this->urlOption());
    $list->append($this->deleteOption());

    if($this->position == 'context') {
      return '<nav class="dropdown dropdown-dark contextmenu">' . $list . '</nav>';
    } else {
      return $list;
    }

  }

  public function __toString() {
    try {
      return (string)$this->html();      
    } catch(Exception $e) {
      return (string)$e->getMessage();
    }
  }

}