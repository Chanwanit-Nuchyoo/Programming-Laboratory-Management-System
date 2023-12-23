<?php
// include('../head.php');
// var_dump($_SESSION['students']);
// $stu_list = $_SESSION['students'];
$quizes = $_SESSION['quizes'];
// $x = json_encode($_SESSION['students']);
// echo '
//     <script> 
//         var stu_mid_quiz21 = ' . $x . ';' .
//     "console.log($x);" . '
//     </script>';
// $x = json_encode($_SESSION['quizes']);
// echo '
//     <script> 
//         var stu_mid_quiz31 = ' . $x . ';' .
//     "console.log($x);" . '
//     </script>';

$i = 1;
?>
<div class="container pt-2">

    <table class="table table-striped" id="datatable">
        <thead>
            <tr>
                <th>NO</th>
                <th>กลุ่ม</th>
                <th>ID</th>
                <th>Name Surname</th>
                <th>Midterm(60)</th>
                <th>Quiz1(10)</th>
                <th>Quiz1A(10)</th>
                <th>Quiz2(10)</th>
                <th title="(Midterm/2) + Max(Quiz1, Quiz1A) + Quiz2">รวม (50)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($quizes as $student) {
                // if (intval($student['mid_score']) < 0 || intval($student['stu_group'])%100==99) 
                //     continue;
                $mid_score = isset($student['mid_score']) ? $student['mid_score'] : 0;
                $quiz1 = isset($student['quiz1']) ? $student['quiz1'] : 0;
                $quiz1A = isset($student['quiz1A']) ? $student['quiz1A'] : 0;
                $quiz2 = isset($student['quiz2']) ? $student['quiz2'] : 0;
                $total = number_format($mid_score / 2 + max($quiz1, $quiz1A) + $quiz2, 2);
            ?>
                <tr>
                    <td>
                        <?php echo $i++; ?>
                    </td>
                    <td>
                        <?php echo $student['stu_group']; ?>
                    </td>
                    <td>
                        <?php echo $student['stu_id']; ?>
                    </td>

                    <td>
                        <?php echo $student['stu_firstname'] . " " .  $student['stu_lastname'];; ?>
                    </td>

                    <td>
                        <?php echo isset($student['mid_score']) ? $student['mid_score'] : -1; ?>
                    </td>
                    <td <?php if ($quiz1 > $quiz1A) echo 'class="text-primary"'; ?>>
                        <?php echo isset($student['quiz1']) ? $student['quiz1'] : -1; ?>
                    </td>
                    <td <?php if ($quiz1 < $quiz1A) echo 'class="text-primary"'; ?>>
                        <?php echo isset($student['quiz1A']) ? $student['quiz1A'] : -1; ?>
                    </td>
                    <td>
                        <?php echo isset($student['quiz2']) ? $student['quiz2'] : -1; ?>
                    </td>
                    <td title=<?php echo '"(' . $mid_score . '/2) + Max(' . $quiz1 . ', ' . $quiz1A . ') + ' . $quiz2 . '"'; ?>>
                        <?php
                        echo $total;
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script src="<?php echo base_url('assets/bootstrap-5.0.0-alpha1-dist/js/bootstrap.bundle.min.js');?>"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!-- <script src="<?php echo base_url('assets/datatables/jquery-3.5.1.js');?>"></script> -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        var dataTable = $('#datatable').DataTable({
            // "info": true,
            "lengthMenu": [
                [15, 30, 60, 120, -1],
                [15, 30, 60, 120, "All"]
            ],
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
                "searchable": false
            }],

            dom: 'l Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'print'
            ]
        });
        var data = dataTable
            .rows()
            .data();

        // alert('The table has ' + data.length + ' records');
        // alert(`${data[1][1]} ${data[1][2]} ${data[1][3]}`);
        table_data = [];
        for (i = 0; i < data.length; i++) {
            table_data[i] = {
                'group': data[i][1],
                'id': data[i][2],
                'mid_score': data[i][3],
                'quiz1': data[i][4]
            };
        }
        grp_006 = table_data.filter(item => item.group == "22010006");
        grp_008 = table_data.filter(item => item.group == "22010008");
        grp_009 = table_data.filter(item => item.group == "22010009");
        grp_010 = table_data.filter(item => item.group == "22010010");
        grp_011 = table_data.filter(item => item.group == "22010011");
    });
</script>
</div>