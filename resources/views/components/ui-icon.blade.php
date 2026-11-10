@props(['name' => 'circle', 'size' => 19])
<svg xmlns="http://www.w3.org/2000/svg" width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" {{ $attributes }}>
    @switch($name)
        @case('menu') <path d="M4 6h16M4 12h16M4 18h16"/> @break
        @case('close') <path d="M18 6 6 18M6 6l12 12"/> @break
        @case('search') <circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/> @break
        @case('dashboard') <rect x="3" y="3" width="8" height="8" rx="1.5"/><rect x="13" y="3" width="8" height="5" rx="1.5"/><rect x="13" y="10" width="8" height="11" rx="1.5"/><rect x="3" y="13" width="8" height="8" rx="1.5"/> @break
        @case('bag') <path d="M4 8h16l-1 13H5L4 8Z"/><path d="M9 9V6a3 3 0 0 1 6 0v3"/> @break
        @case('package') <path d="m12 2 9 5v10l-9 5-9-5V7l9-5Z"/><path d="m3 7 9 5 9-5M12 12v10M7.5 4.5l9 5"/> @break
        @case('grid') <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/> @break
        @case('users') <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/> @break
        @case('chart') <path d="M3 3v18h18"/><path d="m7 15 4-5 3 3 5-7"/> @break
        @case('tag') <path d="M20 13 13 20a2 2 0 0 1-3 0l-7-7V4h9l8 8a2 2 0 0 1 0 1Z"/><circle cx="7.5" cy="8.5" r="1"/> @break
        @case('image') <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/> @break
        @case('settings') <circle cx="12" cy="12" r="3"/><path d="M19.4 15c0 1.2 1.5 2.3 1.5 2.3l-2 2s-1.1-1.5-2.3-1.5-2.3 1.5-2.3 1.5h-2.8s-.3-1.8-1.5-2.3-2.9.3-2.9.3l-2-2s.9-1.7.3-2.9S3 11 3 11V8s1.8-.3 2.3-1.5-.3-2.9-.3-2.9l2-2s1.7.9 2.9.3S11 0 11 0h3s.3 1.8 1.5 2.3 2.9-.3 2.9-.3l2 2s-.9 1.7-.3 2.9S22 8 22 8v3s-1.8.3-2.3 1.5" transform="translate(0 2) scale(.95)"/> @break
        @case('bell') <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/> @break
        @case('chevron-down') <path d="m6 9 6 6 6-6"/> @break
        @case('arrow-right') <path d="M5 12h14m-6-6 6 6-6 6"/> @break
        @case('arrow-up-right') <path d="M7 17 17 7M8 7h9v9"/> @break
        @case('wallet') <rect x="3" y="5" width="18" height="15" rx="2"/><path d="M3 10h18M7 2h10"/> @break
        @case('external') <path d="M13 5h6v6M19 5l-9 9"/><path d="M19 13v6H5V5h6"/> @break
        @case('logout') <path d="M10 17l5-5-5-5M15 12H3"/><path d="M12 3h6a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3h-6"/> @break
        @default <circle cx="12" cy="12" r="9"/> @break
    @endswitch
</svg>
