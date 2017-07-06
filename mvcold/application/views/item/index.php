<form action="<?php echo $url['index'] ?>" method="post">
    <input type="text" value="" name="keyword">
    <input type="submit" value="搜索">
</form>

<p><a href="<?php echo $url['manage'] ?>">新建</a></p>

<table>
    <tr>
        <th>ID</th>
        <th>内容</th>
        <th>操作</th>
    </tr>
    <?php foreach ($items as $item): ?>
        <tr>
            <td><?php echo $item['id'] ?></td>
            <td><?php echo $item['item_name'] ?></td>
            <td>
                <a href="<?php echo $url['manage'] ?>&keywords=<?php echo $item['id'] ?>">编辑</a>
                <a href="<?php echo $url['del'] ?>&id=<?php echo $item['id'] ?>">删除</a>
            </td>
        </tr>
    <?php endforeach ?>
</table>
