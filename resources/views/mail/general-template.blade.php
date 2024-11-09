

<style>
	html, body {
		padding: 0;
		margin: 0;
	}
    .btn-custom {
        background-color: black;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 4px;
        display: inline-block;
    }
	</style>
	<div style="font-family: Arial, Helvetica, sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin: 0; padding: 0; width: 100%; background-color: #edf2f7;">
		<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse; margin: 0 auto; padding: 0; max-width: 600px;">
			<tbody>
				<tr>
					<td align="center" valign="center" style="text-align: center; padding: 40px;">
						<a href="https://sprinthr.com" rel="noopener" target="_blank">
							{{-- <img alt="Logo" src="https://sprinthr.com/wp-content/uploads/elementor/thumbs/cropped-Logo-SprintHR2-1-oyq4hn2e95qd51ul3sqr5rlkrmaqw44qefsj6lkpw8.png" /> --}}
						</a>
					</td>
				</tr>
				<tr>
					<td align="left" valign="center">
						<div style="text-align: left; margin: 0 20px; padding: 40px; background-color: #ffffff; border-radius: 6px;">
							<!--begin:Email content-->
							<div style="padding-bottom: 5px; font-size: 17px;">
                                Good day, {{$receiverName}}
							</div>
							<div >
								<p>{{ $mailMessage }}</p>
							</div>
                                @foreach ($otherMessages as $key => $message)
                                <p style="padding-top: 0; padding-bottom: 0;">
                                    <strong>{{ $key }}</strong>
                                    {{ blank($message) ? 'N/A' : $message }}
                                </p>
                            @endforeach



                            @if(!empty($url))
							<div style="padding-bottom: 40px; text-align: center;">
                                <a href="{{$url}}" class="btn" style="background-color: black; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">
                                    {{ $redirect_action }}
                                </a>
                            </div>
                            @endif


							{{-- <div style="padding-bottom: 30px;">Thank you!</div> --}}
							<!--end:Email content-->
							<div style="padding-bottom: 10px;">Kind regards, {{ $senderName }}<br></div>
						</div>
					</td>
				</tr>
				<tr>
					<td align="center" valign="center" style="font-size: 13px; text-align: center; padding: 20px; color: #6d6e7c;">
						<p></p>
						<p>Copyright ©
						<a href="https://sprinthr.com" rel="noopener" target="_blank">SprintHR</a>.</p>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
