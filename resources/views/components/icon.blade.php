@props(['name'])

@if($name === 'clock')
    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $attributes->get('class') }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m9-3A9 9 0 11 3 12a9 9 0 0118 0z"/>
    </svg>
@elseif($name === 'desktop-computer')
    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $attributes->get('class') }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 21h4.5m1.5-18h-7.5a2.25 2.25 0 00-2.25 2.25v11.25H21V5.25A2.25 2.25 0 0018.75 3z" />
    </svg>
@elseif($name === 'server')
    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $attributes->get('class') }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 16.5A2.5 2.5 0 0118.5 19h-13A2.5 2.5 0 013 16.5v-9A2.5 2.5 0 015.5 5h13A2.5 2.5 0 0121 7.5v9z"/>
    </svg>
@endif
