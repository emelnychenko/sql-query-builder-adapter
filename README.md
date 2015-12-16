# SQL Query Builder Adapter

support:
+ mysql

require:
+ php5.5+
+ php-pdo

composer install:
```
php composer.phar require melnyin/sql-query-builder-adapter
```

packagist link: 
https://packagist.org/packages/melnyin/sql-query-builder-adapter

## Cookbook:

#### \MI\SQL\QB\Adapter

```
$config = [
    'adapter'     => 'mysql',
    'unix_socket' => 'path/to/unix',
    'host'        => 'localhost(127.0.0.1)',
    'username'    => 'root',
    'password'    => 'root',
    'dbname'      => 'root',
    'charset'     => 'utf8',
];

$qbAdapter = new \MI\SQL\QB\Adapter($config);
```

#### \MI\SQL\QB\Query

```
$qbAdapter = new \MI\SQL\QB\Adapter($config);

$qbAdapter->query("SELECT `foo` FROM `bar`");
$qbAdapter->query("DELETE FROM `foo`");
```

#### \MI\SQL\QB\Select

Simple example:
```
$qbAdapter = new \MI\SQL\QB\Adapter($config);

$select = $qbAdapter
  ->select()
  ->from('foo')
  ->query();
  
  SELECT * FROM foo
```

Full example
```  
$qbAdapter = new \MI\SQL\QB\Adapter($config);

$select = $qbAdapter
  ->select('f.id', 'f.title', 'b.date', 'b.phone', 'fb.status')
  ->from('foo', 'f')
  ->join('bar', 'b', ['b.id' => 'f.bar_id'], 'INNER')
  ->join('foobar', 'fb', ['fb.id' => 'b.foobar_id'], 'LEFT')
  ->where('fb.status', ':status')
  ->where([
    'f.id <> :id',
    'f.title LIKE :title",
  ])
  ->param('status', 'open')
  ->param([
    'id'    => 3,
    'title' => 'happyChild',
  ])
  ->order('f.id', 'DESC')
  ->limit(10)
  ->offset(5)
  ->query();
  
  SELECT f.id, f.title, b.date, b.phone, fb.status 
  FROM foo AS f 
  INNER JOIN bar AS b ON b.id = f.bar_id
  LEFT JOIN foobar AS fb ON fb.id = b.foobar_id
  WHERE fb.status = 'open' 
    AND f.id <> 3
    AND f.title LIKE '%happyChild%'
  ORDER BY f.id DESC
  LIMIT 10
  OFFSET 5
```

Select ARRAY Result
```
  $select->toArray();
```

Select OBJECT Result
```
  $select->toObject();
```

Select COUNT Result
```
  $select->count();
```

#### \MI\SQL\QB\Insert

```
$qbAdapter = new \MI\SQL\QB\Adapter($config);

$insert = $qbAdapter
  ->insert('foo')
  ->values('status', 'create')
  ->values([
    'title' => 'bar',
    'date' => '2015-12-06',
  ])
  ->query();

  INSERT INTO foo (status, title, date) VALUES ('create', 'bar', '2015-12-06')
```

#### \MI\SQL\QB\Update

```
$qbAdapter = new \MI\SQL\QB\Adapter($config);

$update = $qbAdapter
  ->update('foo')
  ->set('title', 'bar')
  ->set([
    'date'    => '2015-12-06',
    'status'  => 'create',
  ])
  ->where('id', 5)
  ->query();

  UPDATE foo SET title = 'bar', date = '2015-12-06', status = 'create' WHERE id = 5
```

#### \MI\SQL\QB\Delete

```
$qbAdapter = new \MI\SQL\QB\Adapter($config);

$delete = $qbAdapter
  ->delete()
  ->from('foo')
  ->where('id', 3)
  ->query();

  DELETE FROM foo WHERE id = 3
```
