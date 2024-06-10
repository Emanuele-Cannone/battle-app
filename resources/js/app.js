import './bootstrap';
import './../../vendor/power-components/livewire-powergrid/dist/tailwind.css'


import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Clipboard from '@ryangjchandler/alpine-clipboard'

Alpine.plugin(Clipboard)


import './../../vendor/power-components/livewire-powergrid/dist/powergrid'

Livewire.start()

