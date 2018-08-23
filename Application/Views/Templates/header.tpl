<!DOCTYPE html>
<html lang="{$app_lang}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{$app_description}">

    <title>{block name='title'}{$app_title} - {$app_description}{/block}</title>

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="">
    <meta itemprop="description" content="">
    <meta itemprop="image" content="">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="">
    <meta name="twitter:site" content="">
    <meta name="twitter:title" content="">
    <meta name="twitter:description" content="">
    <meta name="twitter:creator" content="">
    <meta name="twitter:image" content="">

    <!-- Open Graph data -->
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta property="og:description" content="">
    <meta property="og:site_name" content="">

    <!-- favicons -->
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">

    {block name='fonts'}
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway|Source+Sans+Pro" rel="stylesheet">
    {/block}

    {block name='styles'}
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
              integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
              crossorigin="anonymous">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"
              integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ"
              crossorigin="anonymous">
        <!-- Animate.css -->
        <link rel="stylesheet" href="/css/animate.min.css">
        <!-- Custom styles -->
        <link rel="stylesheet" href="/css/style.css">
    {/block}
</head>

<body>

{block name='navbar'}
{include file='Templates/navbar.tpl'}
{/block}