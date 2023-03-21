<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Center Invoice</title>

		<style>
           
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				/* border: 1px solid #eee; */
				/* box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); */
				font-size: 16px;
				line-height: 24px;
				font-family: 'XBRiyaz', sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: 'XBRiyaz', sans-serif;
			}

			.invoice-box.rtl table {
				text-align: center;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: center;
			}
            body{
                font-family: 'XBRiyaz', sans-serif;
                text-align: center;
            }
            @page {
                header: page-header;
                footer: page-footer;
            }
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
                <htmlpageheader name="page-header">
                    Nabadat.app
                </htmlpageheader>
				<tr class="top">
					<td colspan="5">
						<table>
							<tr>
								<td class="title">
									<img src="https://nabadat.app/assets/images/logo/logo.png" style="width: 50%; max-width: 100px" />
								</td>

								<td>
									Invoice #: {{ $invoice->id }}<br />
									Status: {{ $invoice->status_text }}<br />
									Completed at: {{ $invoice->completed_date }}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="5">
						<table>
							<tr>
								<td>
									{{ App\Models\Setting::get('points', 'company_name_en') }}<br />
									{{ App\Models\Setting::get('points', 'primary_phone') }}<br />
									{{ App\Models\Setting::get('points', 'address') }}
								</td>

								<td>
									{{ $invoice->center->user->name }}.<br />
									{{ $invoice->center->user->phone }}<br />
									{{ $invoice->center->address }}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>Num Of Pulses</td>

					<td>Package Name</td>
					<td>Original Price</td>
					<td>Center Dues</td>
					<td>Company Dues</td>
				</tr>

				
                @foreach ($invoice->transactions as $transaction)
                <tr class="details">
                    <td>{{ $transaction->num_pulses }}</td>
                    <td>{{ $transaction->package != null ? $transaction->package->name : "cucstom" }}</td>
                    <td>{{ $transaction->original_price }}</td>
                    <td>{{ $transaction->center_dues }}</td>
                    <td>{{ $transaction->nabadat_app_dues }}</td>
                </tr>
                @endforeach
					
				
				<tr class="total">
					<td colspan="5">Total Center Dues: {{ $invoice->total_center_dues }} LE</td>
				</tr>
				<tr class="total">
					<td colspan="5">Total Nabadat Dues: {{ $invoice->total_nabadat_dues }} LE</td>
				</tr>
			</table>
		</div>
	</body>
</html>