@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-200 bg-gray-50 focus:border-brand-500 focus:bg-white focus:ring-2 focus:ring-brand-500/20 rounded-xl shadow-sm transition-all duration-200']) }}>