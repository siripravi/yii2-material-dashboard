<tr>
    <td><?php echo $item->DESCRIPTION; ?></td>
    <td><?php echo $item->QUANTITY; ?></td>
    <td><?php echo $item->PRICE; ?></td> 
    <td><label><?php echo $item->rowTotal; ?></label></td>
    <td><a href="/web/index.php?r=invoice-items%2Fdelete&amp;id=<?= $item->ID ?>" title="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a></td>
    <td><?= $form->field($item, "[$id]ID")->hiddenInput(array('size' => 10, 'maxlength' => 10)); ?></td>
</tr>