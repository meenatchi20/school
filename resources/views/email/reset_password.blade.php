@extends('layout.student_form')    

<h1>reset Password</h1>

<a href="{{route('reset.password',$token)}}">Reset Password</a>