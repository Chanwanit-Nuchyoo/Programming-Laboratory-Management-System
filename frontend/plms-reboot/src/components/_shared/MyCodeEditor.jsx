/* eslint-disable no-unused-vars */
/* eslint-disable react/prop-types */
import React from 'react';
import CodeMirror from '@uiw/react-codemirror';
import { githubDark } from "@uiw/codemirror-theme-github"
import { python } from '@codemirror/lang-python';

const MyCodeEditor = ({ editable = true, highlight, basicSetup: bs, height, ...props }) => {
  return (
    <CodeMirror
      {...props}
      theme={githubDark}
      extensions={[python()]}
      editable={editable}
      readOnly={!editable}
      basicSetup={{
        tabSize: 4,
        lineNumbers: editable,
        highlightActiveLineGutter: editable,
        highlightSpecialChars: editable,
        history: editable,
        foldGutter: editable,
        drawSelection: editable,
        dropCursor: editable,
        allowMultipleSelections: editable,
        indentOnInput: editable,
        syntaxHighlighting: false,
        bracketMatching: editable,
        closeBrackets: editable,
        autocompletion: editable,
        rectangularSelection: editable,
        crosshairCursor: editable,
        highlightActiveLine: editable,
        highlightSelectionMatches: editable,
        closeBracketsKeymap: editable,
        defaultKeymap: editable,
        searchKeymap: editable,
        historyKeymap: editable,
        foldKeymap: editable,
        completionKeymap: editable,
        lintKeymap: editable,
        ...bs,
      }}
      mode={"python"}
      style={{
        fontSize: "16px",
      }}
    />
  );
};

export default MyCodeEditor;
