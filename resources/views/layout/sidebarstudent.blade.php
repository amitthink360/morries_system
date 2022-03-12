<nav class="sidebar sidebar-offcanvas dynamic-active-class-disabled" id="sidebar">
  <ul class="nav">
    <li class="nav-item {{ active_class(['/exercise']) }}">
      <a class="nav-link" href="{{ url('/exercise') }}">
        <i class="menu-icon mdi mdi-alphabetical"></i>
        <span class="menu-title">Start Exercise</span>
      </a>
    </li>
    <li class="nav-item {{ active_class(['/contactus']) }}">
      <a class="nav-link" href="{{ url('/contactus') }}">
        <i class="menu-icon mdi mdi-contact-mail"></i>
        <span class="menu-title">Contact Us</span>
      </a>
    </li>
  </ul>
</nav>