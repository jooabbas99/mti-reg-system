					<!-- BEGIN .main-footer -->
					<footer class="main-footer">
						{{-- {{dd($settings[0]->footer_text)}} --}}
						<?php $favicon = favicon(); ?>
						{{isset($favicon->footer_text)? $favicon->footer_text: '© '.date('Y')}}
						
					    </div>
					</footer>
					<!-- END: .main-footer -->
					</div>
					<!-- END: .app-main -->
					</div>
					<!-- END: .app-container -->
					</div>
					<!-- END: .app-wrap -->
					<script src="{{asset('assets/admin/plugins/unifyMenu/unifyMenu.js')}}"></script>
					<script src="{{asset('assets/admin/plugins/onoffcanvas/onoffcanvas.js')}}"></script>
					<script src="{{asset('assets/admin/js/moment.js')}}"></script>
					<!-- Slimscroll JS -->
					<script src="{{asset('assets/admin/plugins/slimscroll/slimscroll.min.js')}}"></script>
					<script src="{{asset('assets/admin/plugins/slimscroll/custom-scrollbar.js')}}"></script>
					<script src="{{asset('assets/admin/js/nifty.min.js')}}"></script>
					<!-- Gallery JS -->
					<script src="{{asset('assets/admin/plugins/gallery/baguetteBox.js')}}" async></script>
					<script src="{{asset('assets/admin/plugins/gallery/plugins.js')}}" async></script>
					<script src="{{asset('assets/admin/plugins/gallery/custom-gallery.js')}}" async></script>
					<!-- Data Tables CSS -->
					<link rel="stylesheet" href="{{asset('assets/admin/plugins/datatables/dataTables.bs4.css')}}" />
					<link rel="stylesheet" href="{{asset('assets/admin/plugins/datatables/dataTables.bs4-custom.css')}}" />
					<!-- Data Tables JS -->
					<script src="{{asset('assets/admin/plugins/datatables/dataTables.min.js')}}"></script>
					<script src="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
					<!-- Datepickers css -->
					<link rel="stylesheet" href="{{asset('assets/admin/plugins/datetimepicker/datetimepicker.css')}}" />
					<script src="{{asset('assets/admin/plugins/datetimepicker/datetimepicker.full.js')}}"></script>
					<!-- Common JS -->
					<script src="{{asset('assets/admin/js/common.js?v=1.2')}}"></script>
					</body>

					</html>