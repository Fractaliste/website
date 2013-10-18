@extends('base.layout')

@section('content')
<div class="container" id="forums">

    <ul class="breadcrumb">
        <li><a title="Retour à la page d'accueil" href="{{ route('home') }}"><i class="icon-home"></i></a> <span class="divider">/</span></li>
        <li><a title="Accueil des forums" href="{{ action('\Lvlfr\Forums\Controller\HomeController@index', null, true) }}">Forums</a> <span class="divider">/</span></li>
        <li>{{ $category->title }}</li>
    </ul>

        <a class="" href="javascript:alert('todo');"><i class="icon-plus icon-white"></i> Nouveau sujet</a>

    <div class="row">
        <div class="span12">
            @if(count($topics))
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th colspan="3"><strong>Laravel France</strong></th>
                        <th class="text-center">Messages</th>
                        <th class="text-center">Vues</th>
                        <th>Dernier message</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topics as $topic)
                    <tr>
                        <td style="padding:0" width="1"><div style="min-height:61px"></div></td>
                        <td class="ico-read" width="37"><i class="icon-circle-blank"></i></td>
                        <td>
                            <strong>
                                <a href="{{ action('\Lvlfr\Forums\Controller\TopicsController@show', array($topic->slug, $topic->id), true) }}">
                                   @if($topic->sticky)<i class="icon-flag"></i> @endif {{ $topic->title }}
                                </a>
                            </strong><br>
                            <small>Par {{ $topic->user->username }} le {{ $topic->created_at }}</small>
                        </td>
                        <td class="text-center" width="127">{{ $topic->nb_messages }}</td>
                        <td class="text-center" width="127">{{ $topic->nb_views }}</td>
                        <td width="350">
                            <a href="{{ action('\Lvlfr\Forums\Controller\TopicsController@moveToLast', array($topic->slug, $topic->id), true) }}">
                                {{ $topic->lm_date }}
                            </a><br />
                            <small>Par {{ $topic->lm_user_name }}</small>
                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            {{ $topics->links() }}
        </div>

        <div>
            <strong>Légende :</strong>
            <p class="ico-read">
                <i class="icon-circle"></i> : Messages non lus<br>
                <i class="icon-circle-blank"></i> : Messages lus
            </p>
        </div>

        @else
            <h2>Aucun sujet pour le moment</h2>
        @endif


        <a class="" href="javascript:alert('todo');"><i class="icon-plus icon-white"></i> Nouveau sujet</a>

    </div>
@endsection
