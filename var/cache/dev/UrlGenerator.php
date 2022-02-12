<?php

// This file has been auto-generated by the Symfony Routing Component.

return [
    '_preview_error' => [['code', '_format'], ['_controller' => 'error_controller::preview', '_format' => 'html'], ['code' => '\\d+'], [['variable', '.', '[^/]++', '_format'], ['variable', '/', '\\d+', 'code'], ['text', '/_error']], [], []],
    '_wdt' => [['token'], ['_controller' => 'web_profiler.controller.profiler::toolbarAction'], [], [['variable', '/', '[^/]++', 'token'], ['text', '/_wdt']], [], []],
    '_profiler_home' => [[], ['_controller' => 'web_profiler.controller.profiler::homeAction'], [], [['text', '/_profiler/']], [], []],
    '_profiler_search' => [[], ['_controller' => 'web_profiler.controller.profiler::searchAction'], [], [['text', '/_profiler/search']], [], []],
    '_profiler_search_bar' => [[], ['_controller' => 'web_profiler.controller.profiler::searchBarAction'], [], [['text', '/_profiler/search_bar']], [], []],
    '_profiler_phpinfo' => [[], ['_controller' => 'web_profiler.controller.profiler::phpinfoAction'], [], [['text', '/_profiler/phpinfo']], [], []],
    '_profiler_search_results' => [['token'], ['_controller' => 'web_profiler.controller.profiler::searchResultsAction'], [], [['text', '/search/results'], ['variable', '/', '[^/]++', 'token'], ['text', '/_profiler']], [], []],
    '_profiler_open_file' => [[], ['_controller' => 'web_profiler.controller.profiler::openAction'], [], [['text', '/_profiler/open']], [], []],
    '_profiler' => [['token'], ['_controller' => 'web_profiler.controller.profiler::panelAction'], [], [['variable', '/', '[^/]++', 'token'], ['text', '/_profiler']], [], []],
    '_profiler_router' => [['token'], ['_controller' => 'web_profiler.controller.router::panelAction'], [], [['text', '/router'], ['variable', '/', '[^/]++', 'token'], ['text', '/_profiler']], [], []],
    '_profiler_exception' => [['token'], ['_controller' => 'web_profiler.controller.exception_panel::body'], [], [['text', '/exception'], ['variable', '/', '[^/]++', 'token'], ['text', '/_profiler']], [], []],
    '_profiler_exception_css' => [['token'], ['_controller' => 'web_profiler.controller.exception_panel::stylesheet'], [], [['text', '/exception.css'], ['variable', '/', '[^/]++', 'token'], ['text', '/_profiler']], [], []],
    'agence' => [[], ['_controller' => 'App\\Controller\\AgenceController::index'], [], [['text', '/agence']], [], []],
    'artiste' => [[], ['_controller' => 'App\\Controller\\ArtisteController::index'], [], [['text', '/artiste']], [], []],
    'billet' => [[], ['_controller' => 'App\\Controller\\BilletController::index'], [], [['text', '/billet']], [], []],
    'AfficheBillet' => [[], ['_controller' => 'App\\Controller\\BilletController::Affiche'], [], [['text', '/AfficheB']], [], []],
    'supprimerbillet' => [['id'], ['_controller' => 'App\\Controller\\BilletController::Delete_billet'], [], [['variable', '/', '[^/]++', 'id'], ['text', '/delete']], [], []],
    'app_billet_ajouter_billet' => [[], ['_controller' => 'App\\Controller\\BilletController::Ajouter_billet'], [], [['text', '/billet/ajouter']], [], []],
    'modifierbillet' => [['id'], ['_controller' => 'App\\Controller\\BilletController::Update'], [], [['variable', '/', '[^/]++', 'id'], ['text', '/update']], [], []],
    'equipe' => [[], ['_controller' => 'App\\Controller\\EquipeController::index'], [], [['text', '/equipe']], [], []],
    'AfficheEquipe' => [[], ['_controller' => 'App\\Controller\\EquipeController::Affiche'], [], [['text', '/AfficheE']], [], []],
    'supprimer' => [['id'], ['_controller' => 'App\\Controller\\EquipeController::Delete_joueur'], [], [['variable', '/', '[^/]++', 'id'], ['text', '/delete']], [], []],
    'app_equipe_ajouter_equipe' => [[], ['_controller' => 'App\\Controller\\EquipeController::Ajouter_equipe'], [], [['text', '/equipe/ajouter']], [], []],
    'evenement' => [[], ['_controller' => 'App\\Controller\\EvenementController::index'], [], [['text', '/evenement']], [], []],
    'hebergement' => [[], ['_controller' => 'App\\Controller\\HebergementController::index'], [], [['text', '/hebergement']], [], []],
    'joueur' => [[], ['_controller' => 'App\\Controller\\JoueurController::index'], [], [['text', '/joueur']], [], []],
    'AfficheJoueur' => [[], ['_controller' => 'App\\Controller\\JoueurController::Affiche'], [], [['text', '/AfficheJ']], [], []],
    'delete' => [['id'], ['_controller' => 'App\\Controller\\JoueurController::Delete_joueur'], [], [['variable', '/', '[^/]++', 'id'], ['text', '/delete']], [], []],
    'app_joueur_ajouter_joueur' => [[], ['_controller' => 'App\\Controller\\JoueurController::Ajouter_joueur'], [], [['text', '/joueur/ajouter']], [], []],
    'update' => [['id'], ['_controller' => 'App\\Controller\\JoueurController::Update'], [], [['variable', '/', '[^/]++', 'id'], ['text', '/joueur/update']], [], []],
    'kiosque' => [[], ['_controller' => 'App\\Controller\\KiosqueController::index'], [], [['text', '/kiosque']], [], []],
    'matche' => [[], ['_controller' => 'App\\Controller\\MatcheController::index'], [], [['text', '/matche']], [], []],
    'AfficheMatche' => [[], ['_controller' => 'App\\Controller\\MatcheController::Affiche'], [], [['text', '/AfficheM']], [], []],
    'deleteMatche' => [['id'], ['_controller' => 'App\\Controller\\MatcheController::Delete_matche'], [], [['variable', '/', '[^/]++', 'id'], ['text', '/deleteMatche']], [], []],
    'app_matche_ajouter_matche' => [[], ['_controller' => 'App\\Controller\\MatcheController::Ajouter_matche'], [], [['text', '/matche/ajouter']], [], []],
    'modifier' => [['id'], ['_controller' => 'App\\Controller\\MatcheController::Update'], [], [['variable', '/', '[^/]++', 'id'], ['text', '/updatematch']], [], []],
    'stade' => [[], ['_controller' => 'App\\Controller\\StadeController::index'], [], [['text', '/stade']], [], []],
];
