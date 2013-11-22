<?php

namespace Lvlfr\Wiki\Controller;

use \Auth;
use \Config;
use \Input;
use \Redirect;
use \Str;
use \View;
use Lvlfr\Wiki\Repositories\Page as PageRepo;

class HomeController extends \BaseController
{
    public function __construct(PageRepo $page)
    {
        $this->page = $page;
    }

    public function index($slug = null, $version = null)
    {
        $default = Config::get('LvlfrWiki::wiki.default_page');

        if (is_null($slug)) {
            return Redirect::action('\Lvlfr\Wiki\Controller\HomeController@index', array('slug' => $default));
        }

        $page = $this->page->find($slug, $version);
        if(is_null($page)) {
            return Redirect::action('\Lvlfr\Wiki\Controller\HomeController@create', array('slug' => $slug));
        }

        $isHomepage = ($slug === $default) && ($version === null);

        return View::make('LvlfrWiki::page', array("slug" => $slug, "content" => $page, "isHomepage" => $isHomepage));
    }

    public function edit($slug)
    {
        $page = $this->page->find($slug);

        return View::make('LvlfrWiki::edit', array("slug" => $slug, "content" => $page));
    }

    public function editPage($slug)
    {
        $page = $this->page->find($slug);

        $validator = new \Lvlfr\Wiki\Validation\EditPage(Input::all());

        if ($validator->passes()) {
            $page->title = Input::get('title');
            if (strlen(Str::slug(Input::get('slug'), '_')) > 0 && Auth::user()->hasRole('Wiki')) {
                $page->slug = Str::slug(Input::get('slug'), '_');
            } else {
                $page->slug = Str::slug(Input::get('title'), '_');
            }
            $page->content = Input::get('content');

            $this->page->save($page);

            return Redirect::action('\Lvlfr\Wiki\Controller\HomeController@index', array('slug' => $slug));
        }

        return Redirect::back()->withInput()->withErrors($validator->getErrors());
    }

    public function create()
    {
        $page = new \Lvlfr\Wiki\Entities\Page;

        $page->title = ucfirst(Input::get('slug'));

        return View::make('LvlfrWiki::edit', array("content" => $page));
    }

    public function createPage()
    {
        $page = new \Lvlfr\Wiki\Entities\Page;

        $validator = new \Lvlfr\Wiki\Validation\NewPage(Input::all());

        if ($validator->passes()) {
            $page->title = Input::get('title');
            if (strlen(Str::slug(Input::get('slug'), '_')) > 0) {
                $page->slug = Str::slug(Input::get('slug'), '_');
            } else {
                $page->slug = Str::slug(Input::get('title'), '_');
            }
            $page->content = Input::get('content');

            $this->page->save($page);

            return Redirect::action('\Lvlfr\Wiki\Controller\HomeController@index', array('slug' => $page->slug));
        }

        return Redirect::back()->withInput()->withErrors($validator->getErrors());
    }

    public function versions($slug)
    {
        $page = $this->page->find($slug);
        
        return View::make('LvlfrWiki::versions', array("page" => $page));
    }

    public function listAll()
    {
        $pages = $this->page->all();
        
        return View::make('LvlfrWiki::list', array("pages" => $pages));
    }
}