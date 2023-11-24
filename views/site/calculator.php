<?php

use app\assets\MyCustomAsset;
use yii\bootstrap5\Alert;

MyCustomAsset::register($this);

$this->title = 'Калькулятор';

if (Yii::$app->session->hasFlash('success')) {
	$flashMessage = Yii::$app->session->getFlash('success');
	echo Alert::widget([
		 'options' => $flashMessage['options'],
		 'body' => $flashMessage['message'],
	]);
}
?>


<body class="leading-normal tracking-normal text-indigo-400 m-6 bg-cover bg-fixed">
	<div id="app" class="h-full flex flex-col items-center justify-center">

		<div class="container-fluid h-custom">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="card-body p-md-5" style="max-width: 1000px; border-radius: 50px; background-color: #cce3d7">
					<div class="my-form-container container flex flex-col items-center justify-center">
						<div v-if="calculatedPrice !== null" class="text-center">
							<h1 class="text-3xl md:text-5xl font-bold leading-tight text-center">
								<span class="opacity-75">Калькулятор расчета</span> <br>
								<span class="block text-center opacity-90">доставки сырья</span>
							</h1>

							<div class=" selectedParams bg-black-70 p-4 rounded-md">
								<div class="flex flex-wrap justify-between">
									<div class="w-1/3">
										<div class="border-2 border-gray-500 p-2 rounded-md mr-1">
											<p class="font-bold" style="color: #777f7b;">Месяц:</p>
											<p
												class="bg-gradient-to-r from-purple-500 to-pink-500 text-transparent bg-clip-text animate-pulse text-3xl">
												{{ selectedMonth }}</p>
										</div>
									</div>

									<div class="w-1/3">
										<div class="border-2 border-gray-500 p-2 rounded-md mr-1">
											<p class="font-bold" style="color: #777f7b;">Тип сырья:</p>
											<p
												class=" bg-gradient-to-r from-purple-500 to-pink-500 text-transparent bg-clip-text animate-pulse text-3xl">
												{{ selectedType }}</p>
										</div>
									</div>

									<div class="w-1/3">
										<div class="border-2 border-gray-500 p-2 rounded-md">
											<p class="font-bold" style="color: #777f7b;">Тоннаж:</p>
											<p
												class=" bg-gradient-to-r from-purple-500 to-pink-500 text-transparent bg-clip-text animate-pulse text-3xl">
												{{ selectedTonnage }}</p>
										</div>
									</div>
								</div>
							</div>

							<h1 class="text-3xl mb-1">Расчет выполнен</h1>
							<h2 class="text-xl font-bold mb-4">
								Общая стоимость:<br>
								<span
									class="bg-gradient-to-r from-purple-500 to-pink-500 text-transparent bg-clip-text animate-pulse text-3xl">
									{{ calculatedPrice }}
								</span>
							</h2>

							<div class=" rounded-md shadow overflow-hidden">
								<table class="table-auto w-full text-white-700">
									<thead>
										<tr>
											<td class=" bg-gray-900 p-2 text-light font-bold">T/M</td>
											<template v-for="(tonnage, tonnageIndex) in tonnages">
												<td class="p-2 bg-gray-700 font-bold text-light" :key="tonnageIndex">{{ tonnage }}
												</td>
											</template>
										</tr>
									</thead>
									<tbody>
										<template v-for="(month, monthIndex) in months">
											<tr :class="monthIndex % 2 === 0 ? 'bg-gray-300' : 'bg-gray-200'" :key="monthIndex">
												<td class="p-2 bg-gray-700 text-light font-bold">{{ month }}</td>
												<template v-for="(tonnage, tonnageIndex) in tonnages">
													<td class="p-2 relative" :key="tonnageIndex">
														<div :class="{
									 'ring-2 ring-purple-500 rounded-full text-xl font-bold': month === selectedMonth && tonnage === selectedTonnage,
									 'animate-pulse': month === selectedMonth && tonnage === selectedTonnage
								  }">
															{{ priceArray[(monthIndex * tonnages.length) + tonnageIndex] || '-' }}
														</div>
													</td>
												</template>
											</tr>
										</template>
									</tbody>
								</table>
							</div>

							<button
								class="bg-gradient-to-r from-purple-800 to-green-500 mt-4 hover:from-pink-500 hover:to-green-500 text-white text-center opacity-90 font-bold py-2 px-8 rounded-lg focus:ring transform transition hover:scale-105 duration-300 ease-in-out"
								@click="reset">Выполнить новый расчет
							</button>
						</div>

						<div v-else-if="hasSentRequest === true" class="text-center">
							<div v-if="showErrorModal"
								class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50"
								@click="closeErrorModal">
								<div class="w-full h-full flex items-center justify-center">
									<div class="bg-white p-4 rounded shadow-md">
										<p class="text-lg font-bold text-red-500">**Невозможно выполнить расчет**<br>Для выбранных
											параметров в базе данных недостаточно информации</p>
									</div>
								</div>
							</div>
						</div>

						<div v-else>
							<h1 class="my-4 text-3xl md:text-5xl font-bold leading-tight text-center">
								<span class="opacity-75">Калькулятор расчета</span> <br>
								<span class="block text-center opacity-90 animate-pulse">доставки сырья</span>
							</h1>

							<div class="flex items-center justify-center pt-4">
								<button v-if="showStartButton" id="form-button"
									class="bg-gradient-to-r from-purple-800 to-green-500 hover:from-pink-500 hover:to-green-500 text-white text-center opacity-90 font-bold py-4 px-8 rounded-lg focus:ring transform transition hover:scale-105 duration-300 ease-in-out"
									type="button" @click="openForm">
									Запустить
								</button>


								<div v-if="isFormOpen" class="text-center opacity-90 mt-6">
									<div :class="{'hidden': currentStep !== 1}">
										<select
											class="w-full bg-white rounded border border-gray-400 leading-tight focus:outline-none focus:border-gray-500 py-4 px-6 text-xl"
											v-model="selectedMonth">
											<option value="" disabled selected>Месяц</option>
											<option v-for="month in months" :value="month">{{ month }}</option>
										</select>
										<button
											class="mt-8 bg-purple-500 text-white font-bold py-4 px-8 rounded-lg focus:ring transform transition hover:scale-105 duration-300 ease-in-out"
											@click="nextStep">Далее
										</button>
									</div>

									<div :class="{'hidden': currentStep !== 2}">
										<select
											class="w-full bg-white rounded border border-gray-400 leading-tight focus:outline-none focus:border-gray-500 py-4 px-6 text-xl"
											v-model="selectedType">
											<option value="" disabled selected>Тип сырья</option>
											<option v-for="type in types" :value="type">{{ type }}</option>
										</select>
										<button
											class="mt-8 bg-purple-500 text-white font-bold py-4 px-8 rounded-lg focus:ring transform transition hover:scale-105 duration-300 ease-in-out"
											@click="prevStep">Назад
										</button>
										<button
											class="mt-8 bg-purple-500 text-white font-bold py-4 px-8 rounded-lg focus:ring transform transition hover:scale-105 duration-300 ease-in-out"
											@click="nextStep">Далее
										</button>
									</div>


									<div :class="{'hidden': currentStep !== 3}">
										<select
											class="w-full bg-white rounded border border-gray-400 leading-tight focus:outline-none focus:border-gray-500 py-4 px-6 text-xl"
											v-model="selectedTonnage">
											<option value="" disabled selected>Тоннаж</option>
											<option v-for="tonnage in tonnages" :value="tonnage">{{ tonnage }}</option>
										</select>
										<button
											class="mt-8 bg-purple-500 text-white font-bold py-4 px-8 rounded-lg focus:ring transform transition hover:scale-105 duration-300 ease-in-out"
											@click="prevStep">Назад
										</button>
										<button
											class="mt-3 bg-green-500 text-white font-bold py-4 px-8 rounded-lg focus:ring transform transition hover:scale-105 duration-300 ease-in-out"
											@click="fetchPrice">Рассчитать
										</button>
									</div>
								</div>

								<div v-if="showErrorParams"
									class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50"
									@click="closeErrorParams">
									<div class="w-full h-full flex items-center justify-center">
										<div class="bg-white p-4 rounded shadow-md">
											<p class="text-lg font-bold text-red-500">{{ errorMessage }}</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
</body>