<div class="container">
    <h1>Catálogos</h1>
    <table class="table table-striped">
        <tr>
            <th>Usuarios</th>
            <td><?=count($this->users)?></td>
        </tr>
        <tr>
            <th>Lugares</th>
            <td><?=count($this->places)?></td>
        </tr>
        <tr>
            <th>To-Dos</th>
            <td><?=count($this->todos)?></td>
        </tr>
    </table>
</div>