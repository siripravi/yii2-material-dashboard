<?php $formatter = \Yii::$app->formatter; ?>
<header class="clearfix">
    <div id="hdrl">
        <div id="logo">
            <img src="/images/prime_logo.jpg">
        </div>

        <div id="primeparty">
            <h2 class="name">Prime Party Rentals</h2>
            <div>28971 Hopkins, St #7, Hayward,CA 94545</div>
            <div>Phone: 5107854555, Fax:5102250175</div>
            <div><a href="mailto:info@primepartyrentals.com">info@primepartyrentals.com</a></div>

        </div>
    </div>
    <div id="rtdates">
        <div class='title'>
            <?php echo $statement->invoice->getHeader2(); ?> &nbsp;<small>
                <?php echo $statement->invoice->invoice_id; ?>
            </small>
        </div>
        <span class="rtb">Created On:</span>&nbsp;<span>
            <?php echo $created; ?>
        </span><br />
        <span class="rtb">Event Date:</span>&nbsp;<span>
            <?php echo $formatter->asDatetime($statement->ship_date, 'long', null); ?>
        </span><br />

        <?php if ($statement->paid === '1'): ?>
            <span class="rtb">INVOICE IS PAID</span>
        <?php else: ?>
            <span class="rtb">Final Payment Due:</span>&nbsp;<span>
                <?php echo $dueDate; ?>
            </span>
        <?php endif; ?>

    </div>
</header>
<section id="parties">
    <div id="project">
        <h3 class="name">Customer Details</h3>
        <div id="hcard"><strong>
                <?php echo $statement->customer->first_name . ' ' . $statement->customer->last_name; ?>
            </strong>
            <!--<a class="email" href="mailto:<php echo $statement->customer->email1;?>"><php echo $statement->customer->email1;?></a>-->
            <div class="adr">
                <div class="street-address">
                    <?php echo $statement->customer->address1 . ', ' . $statement->customer->address2; ?>
                </div>
                <div class="xlocality">
                    <?php echo $statement->customer->city; ?>&nbsp;
                    <?php echo $statement->customer->state; ?>&nbsp;
                    <?php echo $statement->customer->zip; ?>
                </div>
            </div>
            <div class="tel">
                <?php echo $statement->customer->phone1; ?>,&nbsp;
                <?php echo $statement->customer->phone2; ?>
            </div>
        </div><!-- e: vcard -->

    </div>

    <div id="company2">


        <h3 class="name">Event/Delivery Place</h3>
        <?php if ($statement->venue->venue_id == 0): ?>
            <div id="hcard"><strong>
                    <?php echo $statement->customer->first_name . ' ' . $statement->customer->last_name; ?>
                </strong>
                <!--<a class="email" href="mailto:<php echo $statement->customer->email1;?>"><php echo $statement->customer->email1;?></a>-->
                <div class="adr">
                    <div class="street-address">
                        <?php echo $statement->customer->address1 . ', ' . $statement->customer->address2; ?>
                    </div>
                    <div class="xlocality">
                        <?php echo $statement->customer->city; ?>&nbsp;
                        <?php echo $statement->customer->state; ?>&nbsp;
                        <?php echo $statement->customer->zip; ?>
                    </div>
                </div>
                <div class="tel">
                    <?php echo $statement->customer->phone1; ?>,&nbsp;
                    <?php echo $statement->customer->phone2; ?>
                </div>
            </div><!-- e: vcard -->

        <?php else: ?>

            <div class="vcard">
                <div class="org"><strong>
                        <?php echo $statement->venue->ship_name; ?>
                    </strong></div>

                <div class="adr">
                    <div class="street-address">
                        <?php echo $statement->venue->ship_add1; ?>,&nbsp;
                        <?php echo $statement->venue->ship_add2; ?>
                    </div>
                    <div class="locality">
                        <?php echo $statement->venue->ship_city; ?>&nbsp;
                        <?php echo $statement->venue->ship_state; ?> &nbsp;
                        <?php echo $statement->venue->ship_zip; ?>
                    </div>
                    <span class="tel">
                        <?php echo $statement->venue->ship_phone1; ?>,&nbsp;
                        <?php echo $statement->venue->ship_phone2; ?>
                    </span>

                </div>
            <?php endif; ?>
        </div><!-- e: vcard -->

    </div>

</section>


<!--  <div class="title"><?php if (!$slip): ?>Invoice<?php else: ?>Packing Slip<?php endif; ?></div> -->

<main>

    <?php //echo date('Y-m-d', strtotime($invoice->statement->CREATE_DATE ));?>

    <table autosize="1">
        <thead>
            <tr>
                <th class="srno">SR#</th>
                <th class="desc">description</th>
                <th class="price">QTY</th>
                <th class="qty">
                    <?php if (!$slip): ?>price
                    <?php endif; ?>
                </th>
                <th class="total">
                    <?php if (!$slip): ?>TOTAL
                    <?php endif; ?>
                </th>
            </tr>

        </thead>
        <tbody>
            <?php foreach ($items as $i => $item): ?>
                <tr>
                    <td class="srno">
                        <?php echo $start; ?>
                    </td>
                    <?php
                    //$lines = explode("\n", wordwrap($item->description, 80, "\n"));
                    $lines = wordwrap($item->description, 80, "<br />\n");
                    // foreach($lines as $line):
                    ?>
                    <td class="desc">
                        <?php echo $lines; ?>
                    </td>
                    <?php //endforeach;  ?>
                    <td class="qty">
                        <?php echo (int) $item->quantity; ?>
                    </td>
                    <td class="unit">
                        <?php if (!$slip)
                            echo $formatter->asCurrency($item->price, 'USD'); ?>
                    </td>
                    <td class="total">
                        <?php if (!$slip)
                            echo $formatter->asCurrency($item->price * $item->quantity, 'USD'); ?>
                    </td>
                </tr>
                <tr>
                    <?php $start += 1;
            endforeach; ?>
        <tfoot>
            <?php echo $page++; ?>{PAGENO}
            <?php if (!$slip): ?>

                <?php if ($grandtotal): ?>
                    <tr>
                        <td colspan="4" class="subtotal">GRAND TOTAL</td>
                        <td class="total">
                            <?php echo $formatter->asCurrency($grandtotal, 'USD'); ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4">PAYMENTS/CREDITS</td>
                        <td class="total">
                            <?php echo $formatter->asCurrency($statement->paymentsTotal, 'USD'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">BALANCE DUE</td>
                        <td class="grand">
                            <?php echo $formatter->asCurrency($grandtotal - $statement->paymentsTotal, 'USD'); ?>
                        </td>
                    </tr>

                <?php else: ?>
                    <tr>
                        <td colspan="4" class="grand total">SUB TOTAL</td>
                        <td class="grand">
                            <?php echo $formatter->asCurrency($subtotal, 'USD'); ?>
                        </td>
                    </tr>
                <?php endif; ?>

            <?php endif; ?>
        </tfoot>
        </tbody>
    </table>
    <div id="notices">
        <div>NOTE:</div>
        <div class="notice">
            prices do no include setup of Chairs, Tables, Linen, China, Silverware unless explicitly specified as a
            separate line item.
            Payment Terms: 50% deposit due on Order Confirmation and the Balance is due 2 weeks prior to the event.
            <!--A finance charge of 1.5% will be made on unpaid balances after 30 days.-->
        </div>
    </div>
</main>
<footer>
    <!-- Invoice was created on a computer and is valid without the signature and seal. -->
</footer>