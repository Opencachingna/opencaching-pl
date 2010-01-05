<?php
/***************************************************************************
											./tpl/stdstyle/myhome.tpl.php
															-------------------
		begin                : Mon June 14 2004
		copyright            : (C) 2004 The OpenCaching Group
		forum contact at     : http://www.opencaching.com/phpBB2

	***************************************************************************/

/***************************************************************************
	*
	*   This program is free software; you can redistribute it and/or modify
	*   it under the terms of the GNU General Public License as published by
	*   the Free Software Foundation; either version 2 of the License, or
	*   (at your option) any later version.
	*
	***************************************************************************/

/****************************************************************************

   Unicode Reminder ??

	 user home

 ****************************************************************************/
?>
		<div class="content2-pagetitle"><img src="tpl/stdstyle/images/blue/home.png" class="icon32" alt="Moje konto" title="Moje konto" align="left" />&nbsp;{{welcome}}, {username}</div>
		<br/><p style="font-size: 12px;">[<a class="links" href="viewprofile.php?userid={userid}">{{view_your_profile}}</a>]</p><br/><br/>
		<p class="content-title-noshade-size3">{founds}&nbsp;{events}</p>
		[<a href="search.php?showresult=1&amp;expert=0&amp;output=HTML&amp;sort=byname&amp;finderid={userid}&amp;searchbyfinder=&amp;f_inactive=0&amp;f_ignored=0&amp;f_userfound=0&amp;f_userowner=0">{{show_all}}</a>]<br/><br/>
			<p class="content-title-noshade-size3"><img src="tpl/stdstyle/images/blue/logs.png" class="icon32" alt="Logs" title="Logs" />&nbsp;{{your_new_log_entries}}:</p>
			<span style="font-weight: 400;">[<a href="myhome2.php">{{show_all}}</a>]</span><br/><br/>
			<table class="table">
				{lastlogs}
			</table>
		<br/>
		<p class="content-title-noshade-size3"><img src="tpl/stdstyle/images/blue/cache.png" class="icon32" alt="Caches" title="Caches" />&nbsp;
		{{number_of_your_hiddens}}: {hidden}</p>
		<span style="font-weight: 400;">[<a href="search.php?showresult=1&amp;expert=0&amp;output=HTML&amp;sort=byname&amp;ownerid={userid}&amp;searchbyowner=&amp;f_inactive=0&amp;f_ignored=0&amp;f_userfound=0&amp;f_userowner=0">{{show_all}}</a>]
		</span><br/><br/>
		<p class="content-title-noshade-size3">{{your_latest_hiddens}}:</p><br/>
		<table class="table">
			{lastcaches}
		</table><br/>
		<p class="content-title-noshade-size3">{{not_yet_published}}:</p>
		<table class="table">
			{notpublishedcaches}
		</table>
		<br/>
		<p class="content-title-noshade-size3">{{your_caches_new_log_entries}}:</p>
		<table class="table">
			{last_logs_in_your_caches}
		</table>
		<br/>

