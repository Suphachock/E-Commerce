<?php include_once "../condb.php" ?>

<table class="table table-striped table-hover text-center">
    <thead class="table-dark">
        <tr>
            <th scope="col">ลำดับ</th>
            <th scope="col">ชื่อผู้ใช้</th>
            <th scope="col">ชื่อ-นามสกุล</th>
            <th scope="col">อีเมล</th>
            <th scope="col">เบอร์โทรศัพท์</th>
            <th scope="col">แก้ไข/ลบ</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Initialize the counter variable
        $counter = 1;

        // Query the database for the members
        $sql = "SELECT * FROM member ORDER BY isAdmin desc";
        $result = mysqli_query($conn, $sql);

        // Check if the query executed successfully
        if ($result) {
            // Loop through the result set
            while ($row = mysqli_fetch_array($result)) {
        ?>
                <tr>
                    <!-- Display the counter as the row number -->
                    <td><?= $counter ?></td>
                    <td>
                        <?php if (!empty($row['isAdmin'])) : ?>
                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                        <?php endif; ?>
                        <?= $row['username'] ?>
                    </td>
                    <td><?= $row['fullname'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['tel'] ?></td>
                    <td>
                        <button class="btn btn-warning" onclick="editMember(<?= $row['id'] ?>)"><i class="fa-regular fa-pen-to-square fa-2xs"></i> แก้ไข</button>
                        <button class="btn btn-danger" onclick="return confirm('Do you want to delete member?',deleteMember(<?= $row['id'] ?>))"><i class="fa-solid fa-trash fa-2xs"></i> ลบ</button>
                    </td>
                </tr>
        <?php
                // Increment the counter for the next row
                $counter++;
            }
        } else {
            // Handle error with the query
            echo "<tr><td colspan='6'>Failed to fetch data. Please try again later.</td></tr>";
        }
        ?>
    </tbody>
</table>