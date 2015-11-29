@extends('schauth::emails.layout')

@section('title')
    Kedves {{ $user['name'] }}!
@stop

@section('body')
    Köszönjük regisztrációdat, szeretettel üdvözlünk a felhasználóink között!<br />
    <br />
    Regisztrációd véglegesítéséhez és a jelszavad megadásához kérjük kattints az alábbi linkre:<br /><br />
    <a href = "{{ $url }}">{{ $url }}</a><br />

    This link will expire in {{ Config::get('auth.reminder.expire', 60) }} minutes.
    <br />
@stop
