<?php

function getFieldName ($template) {
    return FIELD_LIST[strtolower($template)]
        ?? DEFAULT_SORT_FIELD;
}
