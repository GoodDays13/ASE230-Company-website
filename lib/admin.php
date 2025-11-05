<?php
class AdminPage
{
	private $title;
	private $database;

	public function __construct(string $title, Database $database)
	{
		$this->title = $title;
		$this->database = $database;
	}

	public function index($preview): void
	{
		$items = $this->database->readAll();
?>
		<!DOCTYPE html>
		<html>

		<head>
			<meta charset="utf-8" />
			<title><?= $this->title ?></title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			<!-- favicon -->
			<link rel="shortcut icon" href="images/favicon.ico" />

			<!-- css -->
			<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
			<link href="../css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
			<link href="../css/style.min.css" rel="stylesheet" type="text/css" />
		</head>

		<body>
			<div class="container">
				<h1><?= $this->title ?></h1>
			</div>
			<div id="options" class="container mb-3 d-flex justify-content-end">
				<a class="btn btn-primary" href="create.php">Create</a>
			</div>
			<div class="container">
				<div class="list-group">
					<?php foreach ($items as $i => $item) : ?>
						<a href="detail.php?id=<?= $i ?>" class="list-group-item list-group-item-action"><?= $item[$preview] ?></a>
					<?php endforeach ?>
				</div>
			</div>
		</body>

		</html>
	<?php
	}

	public function detail(): void
	{
		$id = $_GET['id'];
		$member = $this->database->read($id);
		if (!$member) {
			http_response_code(404);
			exit;
		}
	?>
		<!DOCTYPE html>
		<html>

		<head>
			<meta charset="utf-8" />
			<title><?= $this->title ?></title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			<!-- favicon -->
			<link rel="shortcut icon" href="images/favicon.ico" />

			<!-- css -->
			<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
			<link href="../css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
			<link href="../css/style.min.css" rel="stylesheet" type="text/css" />
		</head>

		<body>
			<div class="container">
				<h1><?= $this->title ?></h1>
			</div>
			<div id="options" class="container mb-3 d-flex justify-content-end">
				<a class="btn ms-3 btn-primary" href="edit.php?id=<?= $id ?>">Edit</a>
				<a class="btn ms-3 btn-danger" href="delete.php?id=<?= $id ?>">Delete</a>
			</div>
			<div class="container">
				<div class="list-group">
					<?php foreach ($member as $detail) : ?>
						<li class="list-group-item"><?= is_array($detail) ? implode('|', $detail) : $detail ?></li>
					<?php endforeach ?>
				</div>
			</div>
		</body>

		</html>
	<?php
	}

	public function create($template): void
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->database->create($_POST);
			header('Location: index.php');
			exit;
		}
		$this->editForm($template, 'create.php');
	}

	public function edit(): void
	{
		$id = $_GET['id'];
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->database->update($id, $_POST);
			header('Location: index.php');
			exit;
		}
		$this->editForm($this->database->read($id), 'edit.php?id=' . $id);
	}

	public function editForm($item, $action): void
	{
	?>

		<!DOCTYPE html>
		<html>

		<head>
			<meta charset="utf-8" />
			<title><?= $this->title ?></title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			<!-- favicon -->
			<link rel="shortcut icon" href="images/favicon.ico" />

			<!-- css -->
			<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
			<link href="../css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
			<link href="../css/style.min.css" rel="stylesheet" type="text/css" />
		</head>

		<body>
			<div class="container">
				<h1><?= $this->title ?></h1>
			</div>
			<div class="container">
				<form action="<?= $action ?>" method="post">
					<?php foreach ($item as $key => $detail) : ?>
						<div class="form-floating mb-3">
							<?php if (is_array($detail)) : ?>
								<textarea class="form-control" placeholder="Hello, world" id="<?= $key ?>" name="<?= $key ?>" style="height: 10lh"><?= htmlspecialchars(json_encode($detail, JSON_PRETTY_PRINT)) ?></textarea>
							<?php else : ?>
								<input type="text" class="form-control" placeholder="test" id="<?= $key ?>" name="<?= $key ?>" value="<?= $detail ?>">
							<?php endif ?>
							<label for="<?= $key ?>"><?= $key ?></label>
						</div>
					<?php endforeach ?>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</body>

		</html>
	<?php
	}

	public function delete($preview): void
	{
		$id = $_GET['id'];
		if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
			$this->database->delete($id);
			exit;
		}
	?>
		<!DOCTYPE html>
		<html>

		<head>
			<meta charset="utf-8" />
			<title><?= $this->title ?></title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			<!-- favicon -->
			<link rel="shortcut icon" href="images/favicon.ico" />

			<!-- css -->
			<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
			<link href="../css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
			<link href="../css/style.min.css" rel="stylesheet" type="text/css" />
		</head>

		<body>
			<div class="container">
				<h1><?= $this->title ?></h1>
			</div>
			<div class="container">
				<div class="d-flex justify-content-center">
					<div class="card w-50">
						<div class="card-body">
							<h5 class="card-title">Are you sure?</h5>
							<p class="card-text">You are about to delete <?= $this->database->read($id)[$preview] ?>.</p>
							<button class="btn btn-danger" onclick="deleteItem()">Delete</button>
							<a href="index.php" class="btn btn-primary">Cancel</a>
						</div>
					</div>
				</div>
			</div>
		</body>

		<script>
			async function deleteItem() {
				await fetch('delete.php?id=<?= $id ?>', {
					method: 'DELETE'
				});
				window.location.href = 'index.php';
			}
		</script>

		</html>
<?php
	}
}
