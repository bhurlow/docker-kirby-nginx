<?php

class HelpersController extends Controller {

  public function slug() {
    return str::slug(get('string'));
  }

  public function autocomplete($mode) {

    switch($mode) {
      case 'usernames':
        $result = site()->users()->map(function($user) {
          return $user->username();
        })->toArray();
        break;
      case 'emails':
        $result = site()->users()->map(function($user) {
          return $user->email();
        })->toArray();
        break;
      case 'uris':

        $result = site()->index()->map(function($page) {
          return $page->id();
        })->toArray();

        // sort results alphabetically
        sort($result);

        break;
      case 'field':
        $index  = get('index', 'siblings'); // siblings, children, template, all
        $id     = get('uri');
        $page   = page($id);
        switch($index) {
          case 'siblings':
          case 'children':
            $pages = $page->$index();
            break;
          case 'template':
            $template = get('template', $page->template());
            $pages    = site()->index()->filterBy('template', $template);
            break;
          case 'pages':
          case 'all':
            $pages = site()->index();
            break;
          default:
            if($page = site()->page($index)) {
              $pages = $page->children();
            } else {
              return response::json(array());
            }
        }

        $field      = get('field', 'tags');
        $yaml       = get('yaml', false);
        $separator  = get('separator', true);

        if($yaml) {
          $result = array();
          foreach($pages as $page) {
            $values = $page->$yaml()->toStructure()->pluck($field, $separator, true);
            $result = array_merge($result, $values);
          }
          $result = array_unique($result);
        } else {
          $result = $pages->pluck($field, $separator, true);
        }
        break;
      default:
        return response::error('Invalid autocomplete method');
    }

    return response::json(array_values($result));

  }

}
