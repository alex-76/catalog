<table style="border: 1px solid #ddd; border-collapse: collapse; width: 100%;">
    <tbody>
    <?php $i = 1; foreach($data as $key=>$data): ?>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><?= $key ?></td>
            <td style="padding: 8px; border: 1px solid #ddd;"><?= $data ?></td>
        </tr>
        <?php $i++; endforeach; ?>
    </tbody>
</table>