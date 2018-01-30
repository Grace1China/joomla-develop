<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="ohanah module<?php echo $params->get( 'moduleclass_sfx' ) ?>">
	<? if (JComponentHelper::getParams('com_ohanah')->get('showAttendees') != '0') : ?>
		<div class="who_container">
			<div class="who_avatars">
				<? if ($event->who_can_register == "2") : ?>
					<?=@text('OHANAH_REGISTRATION_IS_DISABLED')?>
				<? else : ?>
					<? $attendees = $event->getAttendees() ?>
					<? if (count($attendees)) : ?>
						<? foreach ($attendees as $registration) : ?>
							<? if (!$event->ticket_cost || ($must_pay_to_be_listed_as_attendee_in_paid_events == '0' || ($registration->paid))) : ?>
								<? if ($listStyle == 'both' || $listStyle == 'avatars') : ?>
									<?= $registration->getGravatar() ?>
								<? endif; ?>
								<? if ($listStyle == 'both' || $listStyle == 'names') : ?>
									<span class="attendee_name"><?=$registration->name?></span>
								<? endif; ?>
								<? if ($showNumOfTickets) : ?>
									<span class="number_of_tickets">(<?=$registration->number_of_tickets?>)</span>
								<? endif; ?>
								<hr />
							<? endif ?>
						<? endforeach; ?>
					<? else : ?>
						<span><?=@text('OHANAH_NO_CONFIRMED_ATTENDEES_YET')?></span>

						<? if ($event->who_can_register == '0' || ($event->who_can_register == '1' && !JFactory::getUser()->guest)) : ?>
							<?
							if ($event->get('payment_gateway') != 'none' && $event->ticket_cost) $text = @text('OHANAH_BUY_TICKETS');
							else $text = @text('OHANAH_REGISTER');
							?>

							<? if ($event->limit_number_of_attendees || $event->ticket_cost) : ?>&nbsp;&nbsp;<? endif ?>

							<? if (JComponentHelper::getParams('com_ohanah')->get('itemid')) $itemid = '&Itemid='.JComponentHelper::getParams('com_ohanah')->get('itemid'); else $itemid = '&Itemid='.KRequest::get('get.Itemid', 'int'); ?>

							<? if ($event->registration_system == 'custom') : ?>
							<? else : ?>
								<? if (!$event->limit_number_of_attendees or $event->countAttendees() < $event->attendees_limit) : ?>
									<a href="<?=@route('option=com_ohanah&view=registration&ohanah_event_id='.$event->id.$itemid)?>"><?=@text('OHANAH_BE_THE_FIRST_TO_JOIN')?></a>
								<? else : ?>
									&nbsp;&nbsp;|&nbsp;&nbsp;<?=@text('OHANAH_TICKETS_SOLD_OUT')?>
								<? endif; ?>
							<? endif ?>
						<? endif ?>
					<? endif; ?>
				<? endif; ?>
			</div>
		</div>
	<? endif; ?>
</div>
