<style>
table,
th,
td {
    border: 1px solid black;
    border-collapse: collapse;
}

th,
td {
    padding: 15px;
}

.name {
    align: center;
    text-align: center;
}

.bold-text {
    font-weight: bold;
}

.c1 {
    width: 10%;
    text-align: center;
}

.c2 {
    width: 70%;
}

.c3 {
    width: 20%;
    text-align: end;
}
</style>


<?php

$charges = 5000;

?>

<div class="wrapper">
    <table style="width:100%">
        <tr>
            <td colspan="4" class="name" style="align: center; text-align: center;">
                <h2>PERJ Co-operative Housing Society </h2><br> Address: Vishnu
                Nagar(W),
                Mumbai - 400600
            </td>
        </tr>
        <tr>
            <td colspan="4" class="bold-text name" style="font-weight: bold;align: center;text-align: center;">
                MAINTENANCE BILL</td>
        </tr>
        <tr>
            <td style="width:15%;border: none;">Unit No.: A-101</td>
            <td style="border: none;">Unit Area: 1000 Sq Ft</td>
            <td style="border: none;">Unit Type: Residential</td>
            <td style="border: none;">Bill No.: 1</td>

        </tr>
        <tr>
            <td style="border: none;" colspan="2">Name: PERJ PERJ</td>
            <td style="border: none;" colspan="1">Block No.: A</td>
            <td style="border: none;" colspan="1">Bill Date: 10th March 2021</td>
        </tr>
        <tr>
            <td style="border: none;" colspan="2">Flat Number: 101</td>
            <td style="border: none;" colspan="1">Floor: 1</td>
            <td style="border: none;" colspan="1">Bill For: March 2021</td>

        </tr>
        <tr>
            <td style="border: none;" colspan="3"></td>
            <td style="border: none;" colspan="1">Due Date: 20th April 2021</td>

        </tr>
        </td>
        </tr>
        <tr>
            <th class="c1" style="width: 10%;text-align: center;">Sr No.</th>
            <th class="c2" colspan="2">Particulars of Charges</th>
            <th class="c3" style="width: 20%;text-align: end;">Amount (Rs)</th>
        </tr>
        <tr>
            <td class="c1" style="width: 10%;text-align: center;">1</td>
            <td colspan="2">Sinking Fund</td>
            <td class="c3" style="width: 20%;text-align: end;"><?php echo $charges * 0.0444 ?></td>
            <!-- 4.44% of total -->
        </tr>
        <tr>
            <td class="c1" style="width: 10%;text-align: center;">2</td>
            <td colspan="2">Repair Fund</td>
            <td class="c3" style="width: 20%;text-align: end;"><?php echo $charges * 0.213 ?></td>
            <!-- 21.3% -->
        </tr>
        <tr>
            <td class="c1" style="width: 10%;text-align: center;">3</td>
            <td colspan="2">Electricity Charges</td>
            <td class="c3" style="width: 20%;text-align: end;"><?php echo $charges * 0.1785 ?></td>
            <!-- 17.85% -->
        </tr>
        <tr>
            <td class="c1" style="width: 10%;text-align: center;">4</td>
            <td colspan="2">Water Charges</td>
            <td class="c3" style="width: 20%;text-align: end;"><?php echo $charges * 0.0674 ?></td>
            <!-- 6.74% -->
        </tr>
        <tr>
            <td class="c1" style="width: 10%;text-align: center;">5</td>
            <td colspan="2">Salary Charges</td>
            <td class="c3" style="width: 20%;text-align: end;"><?php echo $charges * 0.2261 ?></td>
            <!-- 22.61% -->
        </tr>
        <tr>
            <td class="c1" style="width: 10%;text-align: center;">6</td>
            <td colspan="2">Lift Maintainance Charges</td>
            <td class="c3" style="width: 20%;text-align: end;"><?php echo $charges * 0.0892 ?></td>
            <!-- 8.92% -->
        </tr>
        <tr>
            <td class="c1" style="width: 10%;text-align: center;">7</td>
            <td colspan="2">Insurance Charges</td>
            <td class="c3" style="width: 20%;text-align: end;"><?php echo $charges * 0.0105 ?></td>
            <!-- 1.05% -->
        </tr>
        <tr>
            <td class="c1" style="width: 10%;text-align: center;">8</td>
            <td colspan="2">Cultural Fund</td>
            <td class="c3" style="width: 20%;text-align: end;"><?php echo $charges * 0.0198 ?></td>
            <!-- 1.98% -->
        </tr>
        <tr>
            <td class="c1" style="width: 10%;text-align: center;">9</td>
            <td colspan="2">Service Charges</td>
            <td class="c3" style="width: 20%;text-align: end;"><?php echo $charges * 0.1511 ?></td>
            <!-- 15.11% -->
        </tr>
        <tr>
            <td colspan="3" style="text-align:right;font-weight:bold;">Total Amount Before due date:</td>
            <td class="c3" style="width: 20%;text-align: end;"> <?php echo "Rs." . $charges; ?></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:right;font-weight:bold;">Total Amount After due date:</td>
            <td class="c3" style="width: 20%;text-align: end;">
                <?php echo "Rs."; ?><?php echo $charges + $charges * 0.21; ?></td>
        </tr>
    </table>
</div>