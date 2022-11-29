<?php
namespace App;

use App\VillaPeruana;

/*
 * Your work begins on LINE 248.
 */

describe('Villa Peruana', function () {

    describe('#tick', function () {

        context ('productos normales', function () {

            it ('actualiza productos normales antes de la fecha de venta', function () {
                $item = VillaPeruana::of('normal', 10, 5); // name, quality, sellIn

                $item->tick();

                expect($item->quality)->toBe(9);
                expect($item->sellIn)->toBe(4);
            });

            it ('actualiza productos normales en la fecha de venta', function () { //bien, está en la fecha de venta y su quality baja por dos.
                $item = VillaPeruana::of('normal', 10, 0);

                $item->tick();

                expect($item->quality)->toBe(8);
                expect($item->sellIn)->toBe(-1);
            });

            it ('actualiza productos normales después de la fecha de venta', function () { // Bien, después de la fecha de venta el producto se degrada dos veces más rápido
                $item = VillaPeruana::of('normal', 10, -5); // name, quality, sellIn

                $item->tick();

                expect($item->quality)->toBe(8); // 10 - 2 = 8 (cuando la fecha de venta ha pasado el quality se degrada por dos)
                expect($item->sellIn)->toBe(-6); // -5 - 1 = -6
            });

            it ('actualiza productos normales cerca de la minima calidad, después de la fecha de venta', function () { //bien, disminuye quality y sellIn, debería ser 2 pero la mínima quality es 0.
                $item = VillaPeruana::of('normal', 1, -5); // name, quality, sellIn

                $item->tick();

                expect($item->quality)->toBe(0);
                expect($item->sellIn)->toBe(-6);
            });

            it ('actualiza productos normales con calidad 0', function () { // bien, a 5 días de la fecha de venta pero ya tiene la minima calidad que es cero.
                $item = VillaPeruana::of('normal', 0, 5);

                $item->tick();

                expect($item->quality)->toBe(0);
                expect($item->sellIn)->toBe(4);
            });

            it ('actualiza productos normales con calidad 0 y después de la fecha de venta', function () { //bien, ya pasó la fecha de venta, se degradaría por dos pero ya cuenta con su mínima calidad
                $item = VillaPeruana::of('normal', 0, -5);

                $item->tick();

                expect($item->quality)->toBe(0);
                expect($item->sellIn)->toBe(-6);
            });

        });


        context('Pisco Peruano', function () {

            it ('actualiza Pisco Peruano antes de la fecha de venta', function () { //bien, pisco peruno aumenta su quality +1.
                $item = VillaPeruana::of('Pisco Peruano', 10, 5);

                $item->tick();

                expect($item->quality)->toBe(11);
                expect($item->sellIn)->toBe(4);
            });

            it ('actualiza Pisco Peruano antes de la fecha de venta con máxima calidad', function () { //bien, quality nunca es mayor a 50
                $item = VillaPeruana::of('Pisco Peruano', 50, 5);

                $item->tick();

                expect($item->quality)->toBe(50);
                expect($item->sellIn)->toBe(4);
            });

            it ('actualiza Pisco Peruano en la fecha de venta', function () { //bien, pisco peruano aumenta su quality +1. (No tomamos la instrucción de tickets VIP')
                $item = VillaPeruana::of('Pisco Peruano', 10, 0);

                $item->tick();

                expect($item->quality)->toBe(11);
                expect($item->sellIn)->toBe(-1);
            });
            // -------------------------------------------------------------------------------------------

            it ('actualiza Pisco Peruano en la fecha de venta, cerca a su máxima calidad', function () { 
                //bien, quality nunca es mayor a 50,
                //(No tomaremos las condiciones del tickets VIP)
                //(si está cerca a su máxima quality 49 y está en la fecha de vencimineto debería aumentar quality + 3)
                //(pero en este caso no ya que no debe pasarse de 50.)
                $item = VillaPeruana::of('Pisco Peruano', 49, 0);

                $item->tick();

                expect($item->quality)->toBe(50);
                expect($item->sellIn)->toBe(-1);
            });

            it ('actualiza Pisco Peruano en la fecha de venta, cerca a su minima calidad', function () { // bien, aumenta su quality y disminuye el sellIn
                $item = VillaPeruana::of('Pisco Peruano', 1, 0);

                $item->tick();

                expect($item->quality)->toBe(2);
                expect($item->sellIn)->toBe(-1);
            });

            it ('actualiza Pisco Peruano en la fecha de venta con máxima calidad', function () {//bien, ya cuenta con la máxima calidad no puede aumentar.
                $item = VillaPeruana::of('Pisco Peruano', 50, 0);

                $item->tick();

                expect($item->quality)->toBe(50);
                expect($item->sellIn)->toBe(-1);
            });

            it ('actualiza Pisco Peruano después de la fecha de venta', function () { // bien, aumenta el quality y disminuye el sellIn.
                $item = VillaPeruana::of('Pisco Peruano', 10, -10);

                $item->tick();

                expect($item->quality)->toBe(11);
                expect($item->sellIn)->toBe(-11);
            });

             it ('actualiza Pisco Peruano después de la fecha de venta con máxima calidad', function () { //bien, ya cuenta con la máxima calidad, no debe aumentar.
                $item = VillaPeruana::of('Pisco Peruano', 50, -10);

                $item->tick();

                expect($item->quality)->toBe(50);
                expect($item->sellIn)->toBe(-11);
            });

        });


        context('Tumi', function () {

            it ('actualiza elementos Tumi antes de la fecha de venta', function () { // bien, no disminuye su fecha de venta ya que no debe ser vendido, su quality es 80 y nunca cambia.
                $item = VillaPeruana::of('Tumi de Oro Moche', 10, 5);

                $item->tick();

                expect($item->quality)->toBe(80); //Un Quality nunca es mayor a 50, sin embargo "Tumi" es un producto legendario y como tal su Quality es 80 y nunca cambia.
                expect($item->sellIn)->toBe(5);
            });

            it ('actualiza elementos Tumi en la fecha de venta', function () {
                $item = VillaPeruana::of('Tumi de Oro Moche', 10, 0);

                $item->tick();

                expect($item->quality)->toBe(80);
                expect($item->sellIn)->toBe(0);
            });

            it ('actualiza elementos Tumi cerca a la fecha de venta y cerca a la mínima calidad', function () {
                $item = VillaPeruana::of('Tumi de Oro Moche', 1, 1);

                $item->tick();

                expect($item->quality)->toBe(80);
                expect($item->sellIn)->toBe(1);
            });

            it ('actualiza elementos Tumi después de la fecha de venta', function () {
                $item = VillaPeruana::of('Tumi de Oro Moche', 10, -1);

                $item->tick();

                expect($item->quality)->toBe(80);
                expect($item->sellIn)->toBe(-1);
            });

        });


        context('Tickets VIP', function () {
            /*
                "Backstage passes", like Pisco Peruano, increases in Quality as it's SellIn
                value approaches; Quality increases by 2 when there are 10 days or
                less and by 3 when there are 5 days or less but Quality drops to
                0 after the concert
             */
            it ('actualiza tickets VIP antes de la fecha del evento', function () { // bien, está a 11 días del evento, por lo que aumenta en 1 su quality.
                $item = VillaPeruana::of('Ticket VIP al concierto de Pick Floid', 10, 11);

                $item->tick();

                expect($item->quality)->toBe(11);
                expect($item->sellIn)->toBe(10);
            });

            it ('actualiza tickets VIP a 10 días de la fecha del evento', function () { // bien, está 10 días del evento, por lo que aumenta en 2 su quality.
                $item = VillaPeruana::of('Ticket VIP al concierto de Pick Floid', 10, 10);

                $item->tick();

                expect($item->quality)->toBe(12);
                expect($item->sellIn)->toBe(9);
            });

            it ('actualiza tickets VIP a 10 días de la fecha del evento, a la mayor calidad', function () { // bien, está a 10 días del evento,pero ya tiene la máxima quality.
                $item = VillaPeruana::of('Ticket VIP al concierto de Pick Floid', 50, 10);

                $item->tick();

                expect($item->quality)->toBe(50);
                expect($item->sellIn)->toBe(9);
            });

            it ('actualiza tickets VIP a 5 días de la fecha del evento', function () { //bien, está a 5 días del evento, por lo que aumenta en 3 su quality.
                $item = VillaPeruana::of('Ticket VIP al concierto de Pick Floid', 10, 5);

                $item->tick();

                expect($item->quality)->toBe(13); // goes up by 3
                expect($item->sellIn)->toBe(4);
            });

            it ('actualiza tickets VIP a 5 días de la fecha del evento, a máxima calidad', function () { //bien, está a 5 días del evento, pero ya tiene su máxima quality.
                $item = VillaPeruana::of('Ticket VIP al concierto de Pick Floid', 50, 5);

                $item->tick();

                expect($item->quality)->toBe(50);
                expect($item->sellIn)->toBe(4);
            });

            it ('actualiza tickets VIP un día antes de la fecha del evento', function () { //bien, está a 1 día del evento, por lo que aumenta en 3 su quality.
                $item = VillaPeruana::of('Ticket VIP al concierto de Pick Floid', 10, 1);

                $item->tick();

                expect($item->quality)->toBe(13);
                expect($item->sellIn)->toBe(0);
            });

            it ('actualiza tickets VIP un día antes de la fecha del evento, a calidad mínima', function () { //bien, está a 1 día del evento, por lo que aumenta en 3 su quality.
                $item = VillaPeruana::of('Ticket VIP al concierto de Pick Floid', 0, 1);

                $item->tick();

                expect($item->quality)->toBe(3);
                expect($item->sellIn)->toBe(0);
            });

            it ('actualiza tickets VIP un día antes de la fecha del evento, a calidad máxima', function () { // bien, está a 1 día del evento pero ya tiene su máxima quality.

                $item = VillaPeruana::of('Ticket VIP al concierto de Pick Floid', 50, 1);

                $item->tick();

                expect($item->quality)->toBe(50);
                expect($item->sellIn)->toBe(0);
            });

            it ('actualiza tickets VIP un día antes de la fecha del evento, cerca de la calidad máxima', function () { // bien, está a 2 día del evento aumentaría 3 pero la máxima quality es 50.

                $item = VillaPeruana::of('Ticket VIP al concierto de Pick Floid', 49, 2);

                $item->tick();

                expect($item->quality)->toBe(50);
                expect($item->sellIn)->toBe(1);
            });

            it ('actualiza tickets VIP en la fecha del evento, con 10 de cualidad', function () {// bien, es la fecha del evento, su quality es cero.

                $item = VillaPeruana::of('Ticket VIP al concierto de Pick Floid', 10, 0);

                $item->tick();

                expect($item->quality)->toBe(0);
                expect($item->sellIn)->toBe(-1);
            });

            it ('actualiza tickets VIP después de la fecha del evento', function () { //bien, ya venció la fecha del evento, su quality es cero.

                $item = VillaPeruana::of('Ticket VIP al concierto de Pick Floid', 10, -1);

                $item->tick();

                expect($item->quality)->toBe(0);
                expect($item->sellIn)->toBe(-2);
            });

            it ('actualiza tickets VIP en la fecha del evento, con 5 de cualidad', function () { //bien, su quality mínima es 0 y ya están en el concierto.

                $item = VillaPeruana::of('Ticket VIP al concierto de Pick Floid', 5, 0);

                $item->tick();

                expect($item->quality)->toBe(0);
                expect($item->sellIn)->toBe(-1);
            });

        });


        context ("Producto de Café", function () {

            it ('actualiza Producto de Café antes de la fecha de venta', function () {
                $item = VillaPeruana::of('Café Altocusco', 10, 10);

                $item->tick();

                expect($item->quality)->toBe(8);
                expect($item->sellIn)->toBe(9);
            });

            it ('actualiza Producto de Café con cualidad 0', function () {
                $item = VillaPeruana::of('Café Altocusco', 0, 10);

                $item->tick();

                expect($item->quality)->toBe(0);
                expect($item->sellIn)->toBe(9);
            });

            it ('actualiza Producto de Café en la fecha de venta', function () {
                $item = VillaPeruana::of('Café Altocusco', 10, 0);

                $item->tick();

                expect($item->quality)->toBe(6);
                expect($item->sellIn)->toBe(-1);
            });

            it ('actualiza Producto de Café en la fecha de venta con calidad 0', function () {
                $item = VillaPeruana::of('Café Altocusco', 0, 0);

                $item->tick();

                expect($item->quality)->toBe(0);
                expect($item->sellIn)->toBe(-1);
            });

            it ('actualiza Producto de Café después de la fecha de venta', function () {
                $item = VillaPeruana::of('Café Altocusco', 10, -10);

                $item->tick();

                expect($item->quality)->toBe(6);
                expect($item->sellIn)->toBe(-11);
            });

            it ('actualiza Producto de Café después de la fecha de venta con calidad 0', function () {
                $item = VillaPeruana::of('Café Altocusco', 0, -10);

                $item->tick();

                expect($item->quality)->toBe(0);
                expect($item->sellIn)->toBe(-11);
            });

        });

    });

});
