<?php


namespace Acme\Adapter;


use Eloquent;

class EloquentStudent  extends Eloquent{
	protected $table = "students";
	protected $fillable = ["name", "email", "score"];

} 