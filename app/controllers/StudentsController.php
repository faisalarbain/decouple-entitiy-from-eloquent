<?php


use Acme\EmailAddress;
use Acme\Student;
use Acme\StudentsRepository;

class StudentsController extends BaseController {

	/**
	 * @var StudentsRepository
	 */
	protected $repository;

	function __construct(StudentsRepository $repository)
	{
		$this->repository = $repository;
	}

	public function index()
	{
		dd($this->repository->all());
	}

	public function store()
	{
		$student = Student::register(
			"John Doe",
			new EmailAddress("john.doe@email.com")
		);

		$this->repository->save($student);
	}

	public function show($id){
		$student = $this->repository->find($id);
		dd($student);
	}

	public function update($id)
	{
		$student = $this->repository->find($id);
		$student->changeEmail(new EmailAddress("changed@email.com"));

		$this->repository->save($student);
	}
} 