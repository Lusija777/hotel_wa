<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.4.0/lightgallery.min.js" integrity="sha512-76iVPLEHY5kfZFCmHBQHLkcE4I2r+gK/I/HLYcm3iCuRO/hopAtyO3AFPCZy5B4347wQ7NftStUBVk/cR21MSw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.4.0/plugins/thumbnail/lg-thumbnail.min.js" integrity="sha512-U/q9/jQoBhMYdo/0oa7Dlb7gntvk0+ASatl5Yxu7gcUUoKs+L8+xROxmrCzgIdGFKS/nB2RiXOxzNfDy18xwXg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.11/flatpickr.min.js" integrity="sha512-fWavsQbEkZyyE0Iiwx2ElW8jj95P3X/mDdUxiLWf4EyuW/AAah+fAbUBcBBIn2pOoGn4Y2+haVPK8VQJ7jw4Iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.11/l10n/sk.min.js" integrity="sha512-u3NI9CA8Pz5pvn/xLmkctFlOxTXa9NgDgSizMROs8OkB9GckceqemEU1nrUe7zi0k3QNFCMT6l3krbF98H056A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', () => {
		document.querySelectorAll('.lightgallery').forEach(function(gallery) {
			lightGallery(gallery, {
				plugins: [lgThumbnail],
				download: false,
				speed: 500,
			});
		});
	
		let pickerInputs = document.querySelectorAll('.js-flatpickr');
		pickerInputs.forEach(pickerInput => {
			
			let today = pickerInput.dataset.today;
			let pickerOptions = {
				position: "below left",
				locale: "sk",
			
				altInput: true,
				altFormat: 'j.n.Y',
				dateFormat: 'Y-m-d',
				mode: 'range',
				showMonths: 2,
				minDate: today,
				
			};

			flatpickr(pickerInput, pickerOptions);
		});
	});
</script>