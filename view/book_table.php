<?php include_once "../condb.php" ?>
<table class="table text-center">
    <thead class="table-dark">
        <tr>
            <th scope="col">ไอดี</th>
            <th scope="col">รูปหนังสือ</th>
            <th scope="col">ชื่อหนังสือ</th>
            <th scope="col">ราคา(บาท)</th>
            <th scope="col">คงเหลือ(เล่ม)</th>
            <th scope="col">แก้ไข/ลบ</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM product ORDER BY pd_id";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?= $row['pd_id'] ?></td>
                <td><img src="img/<?= $row['pd_image'] ?>" width="100px"></td>
                <td><?= $row['pd_name'] ?></td>
                <td>฿<?= $row['pd_price'] ?></td>
                <td><?= $row['pd_qty'] ?></td>
                <td>
                    <button class="btn btn-warning" onclick="show_md_book_edit('<?= $row['pd_id'] ?>')">แก้ไข</button>
                    <button class="btn btn-danger " onclick="return confirm('Do you want to delete book!!',delete_book('<?= $row['pd_id'] ?>'))">ลบ</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>