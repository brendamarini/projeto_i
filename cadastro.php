<?php
header('Access-Control-Allow-Origin: *');

$connect = new PDO("mysql:host=localhost;dbname=id20421067_cebulo", "id20421067_joaovictor", "]lHN#ivf0DjFu_EE");
$received_data = json_decode(file_get_contents("php://input"));
$data = array();
if ($received_data->action == 'fetchall') {
    $query = "
 SELECT * FROM pi 
 ORDER BY id DESC
 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data);
}
if ($received_data->action == 'Enviar') {
    $data = array(
        ':nome' => $received_data->nome,
        ':doacao' => $received_data->doacao,
        ':mensagem' => $received_data->mensagem
    );

    $query = "
 INSERT INTO pi  
 (nome, doacao, mensagem) 
 VALUES (:nome, :doacao, :mensagem)
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data);

    $output = array(
        'message' => 'Doação realizada, Deus te abençoe'
    );

    echo json_encode($output);
}
if ($received_data->action == 'fetchSingle') {
    $query = "
 SELECT * FROM pi 
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    foreach ($result as $row) {
        $data['id'] = $row['id'];
        $data['nome'] = $row['nome'];
        $data['doacao'] = $row['doacao'];
        $data['mensagem'] = $row['mensagem'];
    }

    echo json_encode($data);
}

?>