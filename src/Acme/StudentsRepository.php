<?php


namespace Acme;


use Illuminate\Support\Collection;

interface StudentsRepository {
	/**
	 * @param Student $student
	 * @return mixed
	 */
	public function save(Student $student);

	/**
	 * @param $id
	 * @return Student
	 */
	public function find($id);

	/**
	 * @return Collection
	 */
	public function all();
} 