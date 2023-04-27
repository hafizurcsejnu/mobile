<?php
  use App\Models\Setting;
  $settings = Setting::where('client_id', session('user.client_id'))->first();
?>