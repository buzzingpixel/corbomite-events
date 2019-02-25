# Corbomite Events

<p><a href="https://travis-ci.org/buzzingpixel/corbomite-events"><img src="https://travis-ci.org/buzzingpixel/corbomite-events.svg?branch=master"></a></p>

Part of BuzzingPixel's Corbomite project.

Provides event registration and dispatching.

## Usage

## Listening for events

When the dispatcher is called, it first fires up a collector service which will load up any events. You can register events in your app or from any composer package by setting a key in the composer.json `extra` object of `eventCollectorConfigFilePath`. That should be a path to a PHP file which will be called. The called PHP file will have a variable available called `$eventListenerRegistration`. That's an instance of `\corbomite\events\interfaces\EventListenerRegistrationInterface` which will allow you to register events.

Listeners must implement the interface `\corbomite\events\interfaces\EventListenerInterface`.

## Dispatching events

To dispatch an event, get `\corbomite\events\EventDispatcher` from the DI and call the `dispatch` sending it an instance of the event class you wish to dispatch. That event class instance must implement `\corbomite\events\interfaces\EventInterface`.

## License

Copyright 2019 BuzzingPixel, LLC

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at [http://www.apache.org/licenses/LICENSE-2.0](http://www.apache.org/licenses/LICENSE-2.0).

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
