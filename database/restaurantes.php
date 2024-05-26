<?php
function registrarEmpresa($pdo, $nome, $morada, $telemovel, $email, $tipo, $password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO Empresas (nome, morada, telemovel, email, tipo, password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $morada, $telemovel, $email, $tipo, $hash]);
}

function atualizarEmpresa($pdo, $id, $nome, $morada, $telemovel, $email, $tipo) {
    if($id != $_SESSION['id_empresa']){
        exit("You cant update other people's companies!");
    }

    $sql = "UPDATE Empresas SET nome = ?, morada = ?, telemovel = ?, email = ?, tipo = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $morada, $telemovel, $email, $tipo, $id]);
}

function removerEmpresa($pdo, $id) {
    if($id != $_SESSION['id_empresa']){
        exit("You cant delete other people's companies!");
    }

    $sql = "DELETE FROM Empresas WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
}

function buscarEmpresa($pdo, $id) {
    if($id != $_SESSION['id_empresa']){
        exit("You cant search other people's companies!");
    }

    $sql = "SELECT * FROM Empresas WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function adicionarPermissao($pdo, $id_empresa, $permissao) {
    if($id_empresa != $_SESSION['id_empresa']){
        exit("You cant update other people's companies!");
    }

    $sql = "INSERT INTO PermissoesEmpresa (id_empresa, permissao) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_empresa, $permissao]);
}

function removerPermissao($pdo, $id_empresa, $permissao) {
    if($id_empresa != $_SESSION['id_empresa']){
        exit("You cant update other people's companies!");
    }

    $sql = "DELETE FROM PermissoesEmpresa WHERE id_empresa = ? AND permissao = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_empresa, $permissao]);
}

function listarPermissoes($pdo, $id_empresa) {
    if($id_empresa != $_SESSION['id_empresa']){
        exit("You cant update other people's companies!");
    }

    $sql = "SELECT permissao FROM PermissoesEmpresa WHERE id_empresa = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_empresa]);
    return $stmt->fetchAll();
}

function adicionarEstabelecimento($pdo, $nome, $localizacao, $telemovel, $id_empresa) {
    if($id_empresa != $_SESSION['id_empresa']){
        exit("You cant update other people's companies!");
    }

    $sql = "INSERT INTO Estabelecimentos (nome, localizacao, telemovel, id_empresa) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $localizacao, $telemovel, $id_empresa]);
}

function editarEstabelecimento($pdo, $id, $nome, $localizacao, $telemovel) {
    $sql = "UPDATE Estabelecimentos SET nome = ?, localizacao = ?, telemovel = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $localizacao, $telemovel, $id]);
}

function removerEstabelecimento($pdo, $id) {
    if($id != $_SESSION['id_empresa']){
        exit("You cant update other people's companies!");
    }

    $sql = "DELETE FROM Estabelecimentos WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
}

function visualizarEstatisticasVendas($pdo, $id_empresa) {
    if($id_empresa != $_SESSION['id_empresa']){
        exit("You cant update other people's companies!");
    }

    $sql = "SELECT SUM(precoTotal) as TotalVendas FROM Pedidos JOIN Estabelecimentos ON Pedidos.id_estabelecimento = Estabelecimentos.id WHERE Estabelecimentos.id_empresa = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_empresa]);
    return $stmt->fetchColumn();
}