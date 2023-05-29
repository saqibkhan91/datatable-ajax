<?php
include 'config.php';

$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length'];
$columnIndex = $_POST['order'][0]['column'];
$columnName = $_POST['columns'][$columnIndex]['data'];
$columnSortOrder = $_POST['order'][0]['dir'];
$searchValue = $_POST['search']['value'];

$searchArray = array();
$searchQuery = " ";
if($searchValue != ''){
	$searchQuery = " AND (user_id LIKE :user_id or 
        user_name LIKE :user_name  ) ";
    $searchArray = array(
        'user_id'=>"%$searchValue%",
        'user_name'=>"%$searchValue%",
    );
}

$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM user ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM user WHERE 1 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

$stmt = $conn->prepare("SELECT * FROM user WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");


foreach($searchArray as $key=>$search){
    $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
}

$stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
$stmt->execute();
$empRecords = $stmt->fetchAll();

$data = array();

foreach($empRecords as $row){
    $data[] = array(
            "user_id"=>$row['user_id'],
            "user_name"=>$row['user_name'],
            );
}

$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);
