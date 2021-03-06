<?php

/**
 * В этом файле собраны наиболее часто встречающиеся примеры кода и готовые решения использования api Битркса
 * Рекомендуется сохранить как live template для phpStorm
 */

/**
 * Получаем список элементов
 */
$arSelect = Array(
	"ID",
	"NAME"
);
$arFilter = Array(
	"IBLOCK_ID" => "",
	"ACTIVE" => "Y"
);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
$count = $res->SelectedRowsCount(); // количество полученных записей из таблицы
while ($ob = $res->GetNext()) {
	print_r($ob);
}

/**
 * Ресайз картинки
 */
$file = CFile::ResizeImageGet($file_id, array('width' => 150, 'height' => 150), BX_RESIZE_IMAGE_PROPORTIONAL, true); // BX_RESIZE_IMAGE_EXACT

/**
 * Добавление элемента в базу данных
 */
$el = new \CIBlockElement();
$arLoadProductArray = Array();
$arLoadProductArray["IBLOCK_ID"] = (int)"";
$arLoadProductArray["IBLOCK_SECTION_ID"] = (int)"";
$arLoadProductArray["NAME"] = "Название";
$arLoadProductArray["ACTIVE"] = "Y";
$arLoadProductArray["PREVIEW_TEXT"] = "";
$arLoadProductArray['PREVIEW_TEXT_TYPE'] = 'html'; // тип текста для PREVIEW_TEXT можно указать при необходимости: text, html, editor
$arLoadProductArray["PROPERTY_VALUES"]["HTML_OR_TEXT"][0] = array("VALUE" => array("TEXT" => $html_text, "TYPE" => "html")); // добавления свойства типа HTML/Текст
$arLoadProductArray["PROPERTY_VALUES"]["STATUS"] = "Значение"; // свойство
if ($elementID = $el->Add($arLoadProductArray)) {
} else {
	echo "Error: " . $el->LAST_ERROR;
}

/**
 * Изменение элемента
 */
$el = new CIBlockElement;
$PROP = array();
$PROP[12] = "Белый"; // свойству с кодом 12 присваиваем значение "Белый"
$PROP[3] = 38; // свойству с кодом 3 присваиваем значение 38
$arLoadProductArray = Array(
	"MODIFIED_BY" => $USER->GetID(), // элемент изменен текущим пользователем
	"IBLOCK_SECTION" => false, // элемент лежит в корне раздела
	"PROPERTY_VALUES" => $PROP,
	"NAME" => "Элемент",
	"ACTIVE" => "Y", // активен
	"PREVIEW_TEXT" => "текст для списка элементов",
	"DETAIL_TEXT" => "текст для детального просмотра",
	"DETAIL_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . "/image.gif")
);
$PRODUCT_ID = 2; // изменяем элемент с кодом (ID) 2
$res = $el->Update($PRODUCT_ID, $arLoadProductArray);

/**
 * Создание массива информации о файле (например для добавления в PREVIEW_PICTURE элемента:
 * $arLoadProductArray['PREVIEW_PICTURE'] = $arFile;
 */
$arFile = \CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . $_POST['pic']);


/**
 * Изменение значения свойства элемента
 */
\CIBlockElement::SetPropertyValuesEx($item['ID'], false,
	array(
		'QUANTITY' => ($item['PROPERTY_QUANTITY_VALUE'] + 1),
		'NAME' => ($_POST['name']),
		'ELEMENT' => ($_POST['element']),
		'PRICE' => $_POST['price']
	)
);

/**
 * Получение списка разделов
 */
$arFilter = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arResult['SECTION']['IBLOCK_SECTION_ID']); // выберет потомков без учета активности
$arSelect = array('UF_*');
$rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'), $arFilter, false, $arSelect);
while ($arSect = $rsSect->GetNext()) {
	\BitrixHelper\Utils::Message($arSect);
}

/**
 * Подключение модулей
 */
CModule::IncludeModule("iblock"); // подключение информационных блоков


/**
 * Список пользователей
 */
$rsUsers = CUser::GetList(($by = "LAST_NAME"), ($order = "asc"), $filter = array());
while ($arUser = $rsUsers->GetNext()) {
	\BitrixHelper\Utils::Message($arUser);
}

/**
 * Изменение информации о пользователе
 */
$user = new CUser;
$fields = Array(
	"EMAIL" => 'undefined@mail.com',
);
$user->Update($arUser['ID'], $fields);