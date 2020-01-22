<?php
echo "Logado como:  $usuario ";
echo br();
echo "Perfil: $perfil";
echo br(2);

echo "<div id=\"cssmenu\">";
echo "<ul> ";
foreach ($menu_item as $key => $value) {
    echo "<li>";
    echo anchor($key, $value);
    echo "</li>";
}
echo "</ul>";
echo "</div>";
echo br(2);
?>

<div class="layout">
     <main>
        <div class = "container">
            <!--<div class =" row-fluid">-->
            <div id="content" class="span9">
                <section id="content-section">