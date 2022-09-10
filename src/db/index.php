<?php
/**
 * Connect to DB
 */

/** @var \PDO $pdo */
require_once './pdo_ini.php';

function buildHttpQuery(...$params): string
{
    return '?' . http_build_query(array_merge($_GET, ...$params));
}

/**
 * SELECT the list of unique first letters using https://www.w3resource.com/mysql/string-functions/mysql-left-function.php
 * and https://www.w3resource.com/sql/select-statement/queries-with-distinct.php
 * and set the result to $uniqueFirstLetters variable
 */

$sth = $pdo->query('SELECT DISTINCT LEFT(name, 1) AS letter FROM airports ORDER BY letter');
$uniqueFirstLetters = $sth->fetchAll(PDO::FETCH_COLUMN);

// Filtering
/**
 * Here you need to check $_GET request if it has any filtering
 * and apply filtering by First Airport Name Letter and/or Airport State
 * (see Filtering tasks 1 and 2 below)
 *
 * For filtering by first_letter use LIKE 'A%' in WHERE statement
 * For filtering by state you will need to JOIN states table and check if states.name = A
 * where A - requested filter value
 */

$filter = '';

if (isset($_GET['filter_by_first_letter'])) {
    $filter = "WHERE airports.name LIKE '{$_GET['filter_by_first_letter']}%'";
}

if (isset($_GET['filter_by_state'])) {
    $filter .= $filter ? ' AND ' : 'WHERE ';
    $filter .= "states.name = '{$_GET['filter_by_state']}'";
}

// Sorting
/**
 * Here you need to check $_GET request if it has sorting key
 * and apply sorting
 * (see Sorting task below)
 *
 * For sorting use ORDER BY A
 * where A - requested filter value
 */

$sort = isset($_GET['sort']) ? "ORDER BY {$_GET['sort']}" : "ORDER BY name";

// Pagination
/**
 * Here you need to check $_GET request if it has pagination key
 * and apply pagination logic
 * (see Pagination task below)
 *
 * For pagination use LIMIT
 * To get the number of all airports matched by filter use COUNT(*) in the SELECT statement with all filters applied
 */

const LIMIT_PER_PAGE = 5;

$currentPage = $_GET['page'] ?? 1;

$airportsCount = $pdo->query(<<<SQL
    SELECT COUNT(*)
    FROM airports
    JOIN states ON states.id = airports.state_id
    JOIN cities ON cities.id = airports.city_id
    {$filter}
SQL)->fetchColumn();

$totalPages = ceil($airportsCount / LIMIT_PER_PAGE);
// Start number of pagination button
$firstPageNumber = $currentPage <= 7 ? 1 : max($currentPage - 3, 1);
// Last number of pagination button
$lastPageNumber = $currentPage < 4 ? min(7, $totalPages) : min($currentPage + 3, $totalPages);

$limit = 'LIMIT ' . LIMIT_PER_PAGE;
$offset = 'OFFSET ' . ($currentPage - 1) * LIMIT_PER_PAGE;

/**
 * Build a SELECT query to DB with all filters / sorting / pagination
 * and set the result to $airports variable
 *
 * For city_name and state_name fields you can use alias https://www.mysqltutorial.org/mysql-alias/
 */

$sql = <<<SQL
    SELECT
        airports.name AS name,
        airports.code AS code,
        states.name AS state,
        cities.name AS city,
        airports.address AS address,
        airports.timezone AS timezone
    FROM airports
    JOIN states ON states.id = airports.state_id
    JOIN cities ON cities.id = airports.city_id
    {$filter}
    {$sort}
    {$limit}
    {$offset}
SQL;

$airports = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Airports</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<main role="main" class="container">

    <h1 class="mt-5">US Airports</h1>

    <!--
        Filtering task #1
        Replace # in HREF attribute so that link follows to the same page with the filter_by_first_letter key
        i.e. /?filter_by_first_letter=A or /?filter_by_first_letter=B

        Make sure, that the logic below also works:
         - when you apply filter_by_first_letter the page should be equal 1
         - when you apply filter_by_first_letter, than filter_by_state (see Filtering task #2) is not reset
           i.e. if you have filter_by_state set you can additionally use filter_by_first_letter
    -->
    <div class="alert alert-dark">
        Filter by first letter:

        <?php foreach ($uniqueFirstLetters as $letter): ?>
            <a href="<?= buildHttpQuery(['filter_by_first_letter' => $letter], ['page' => 1]); ?>"><?= $letter ?></a>
        <?php endforeach; ?>

        <a href="/src/db/" class="float-right">Reset all filters</a>
    </div>

    <!--
        Sorting task
        Replace # in HREF so that link follows to the same page with the sort key with the proper sorting value
        i.e. /?sort=name or /?sort=code etc

        Make sure, that the logic below also works:
         - when you apply sorting pagination and filtering are not reset
           i.e. if you already have /?page=2&filter_by_first_letter=A after applying sorting the url should looks like
           /?page=2&filter_by_first_letter=A&sort=name
    -->
    <table class="table">
        <thead>
        <tr>
            <th scope="col"><a href="<?= buildHttpQuery(['sort' => 'name']) ?>">Name</a></th>
            <th scope="col"><a href="<?= buildHttpQuery(['sort' => 'code']) ?>">Code</a></th>
            <th scope="col"><a href="<?= buildHttpQuery(['sort' => 'state']) ?>">State</a></th>
            <th scope="col"><a href="<?= buildHttpQuery(['sort' => 'city']) ?>">City</a></th>
            <th scope="col">Address</th>
            <th scope="col">Timezone</th>
        </tr>
        </thead>
        <tbody>
        <!--
            Filtering task #2
            Replace # in HREF so that link follows to the same page with the filter_by_state key
            i.e. /?filter_by_state=A or /?filter_by_state=B

            Make sure, that the logic below also works:
             - when you apply filter_by_state the page should be equal 1
             - when you apply filter_by_state, than filter_by_first_letter (see Filtering task #1) is not reset
               i.e. if you have filter_by_first_letter set you can additionally use filter_by_state
        -->
        <?php foreach ($airports as $airport): ?>
        <tr>
            <td><?= $airport['name'] ?></td>
            <td><?= $airport['code'] ?></td>
            <td><a href="<?= buildHttpQuery(['filter_by_state' => $airport['state']], ['page' => 1]); ?>">
                    <?= $airport['state'] ?></a></td>
            <td><?= $airport['city'] ?></td>
            <td><?= $airport['address'] ?></td>
            <td><?= $airport['timezone'] ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!--
        Pagination task
        Replace HTML below so that it shows real pages dependently on number of airports after all filters applied

        Make sure, that the logic below also works:
         - show 5 airports per page
         - use page key (i.e. /?page=1)
         - when you apply pagination - all filters and sorting are not reset
    -->
    <nav aria-label="Navigation">
        <ul class="pagination justify-content-center">
            <?php for ($i = $firstPageNumber; $i <= $lastPageNumber; $i++): ?>
                <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                    <a class="page-link" href="<?= buildHttpQuery(['page' => $i]) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

</main>
</html>
