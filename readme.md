# Experiment to decouple Entity from Eloquent

This experiment is based on Laracast [Enforcement, Entities, and Eloquent ](https://laracasts.com/lessons/enforcement-entities-and-eloquent) video tutorial.

## objective:
- to keep Entity as Plain Old PHP Object (POPO)
- to use Eloquent to persist and load entity without having to expose all fields via getters and setters
- to implement repository that use POPO entity for persistent and return POPO entity for query.

## Approach
 
#### Student Entity

Student entity is just a simple PHP class with all attributes set as `protected`

```
namespace Acme;


class Student {

	protected $name;
	/**
	 * @var EmailAddress
	 */
	protected $email;
	/**
	 * @var Score
	 */
	protected $score;

	protected $id;

	protected function __construct($name, EmailAddress $email)
	{
		$this->name = $name;
		$this->email = $email;
		$this->score = new Score(100);
	}

	public static function register($name, $email){
		return new static($name, $email);
	}

	public function changeEmail(EmailAddress $email){
		$this->email = $email;
	}

	public function getId(){
		return $this->id;
	}
} 
```

#### StudentsRepository
Students repository explicitly define `Student` entity class.

```
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
```

#### Eloquent implementation for StudentsRepository 
Eloquent repository use an `EloquentStudentProxy` to map `Student` entity to eloquent model vice versa

```
<?php


namespace Acme\Adapter;

use Acme\Student;
use Acme\StudentsRepository;

class EloquentStudentsRepository implements StudentsRepository {

	public function save(Student $student)
	{
		$model = EloquentStudentProxy::toEloquent($student);
		$model->save();
	}

	public function find($id)
	{
		$model = EloquentStudent::find($id);
		return EloquentStudentProxy::toEntity($model);
	}

	public function all()
	{
		return EloquentStudent::all()->map(function($model){
			return EloquentStudentProxy::toEntity($model);
		});
	}
}
```

#### EloquentStudentProxy
Actually I not sure what to name this class and just call it as proxy. The main idea for this class is to map `Student` entity to eloquent model and create `Student` entity from eloquent model.

Since `EloquentStudentProxy` extends `Student` class, the class able to access all protected fields in `Student` class. This is to elinate needs for getter and setter and leave our entity with business logic only.

```
namespace Acme\Adapter;


use Acme\EmailAddress;
use Acme\Score;
use Acme\Student;

class EloquentStudentProxy extends Student{

	public static function toEloquent($student)
	{
		$model =  EloquentStudent::findOrNew($student->id);

		$model->fill([
			"name" => $student->name,
			"email" => (string) $student->email,
			"score" => (string) $student->score
		]);

		return $model;
	}

	public static function toEntity($model)
	{
		$student = new Student($model->name, new EmailAddress($model->email));
		$student->score = new Score($model->score);
		$student->id = $model->id;
		return $student;
	}
}
```

### The Rest

#### Eloquent Model
So this is the eloquent model that used to persist the entity

```
namespace Acme\Adapter;


use Eloquent;

class EloquentStudent  extends Eloquent{
	protected $table = "students";
	protected $fillable = ["name", "email", "score"];

} 
```

#### The Controller

##### Register Student
```
public function store(){
	$student = Student::register(
		"John Doe",
		new EmailAddress("john.doe@email.com")
	);

	$this->repository->save($student);
}

```
Controller will use `Student` class to register student. 


##### Retrieve student
```
public function show($id){
	$student = $this->repository->find($id);
	dd($student);
}
```
guess the output is:

```
object(Acme\Student)[137]
  protected 'name' => string 'John Doe' (length=8)
  protected 'email' => 
    object(Acme\EmailAddress)[146]
      private 'email' => string 'john.doe@email.com' (length=18)
  protected 'score' => 
    object(Acme\Score)[149]
      protected 'score' => string '100' (length=3)
  protected 'id' => string '1' (length=1)
```

##### change student email
```
public function update($id){
	$student = $this->repository->find($id);
	$student->changeEmail(new EmailAddress("changed@email.com"));

	$this->repository->save($student);
}
```

#### list all students
```
public function index(){
	dd($this->repository->all());
}
```