/* eslint-disable react/prop-types */
import {
  insertImages,
  RichTextEditor,
  LinkBubbleMenu,
  TableBubbleMenu
} from "mui-tiptap";
import { Button, Box } from "@mui/material";
import { useRef, useCallback, useEffect } from "react";
import { extensions } from "@/utils/tiptap-extensions";
import MyRteMenus from "./MyRteMenus";

function fileListToImageFiles(fileList) {
  // You may want to use a package like attr-accept
  // (https://www.npmjs.com/package/attr-accept) to restrict to certain file
  // types.
  return Array.from(fileList).filter((file) => {
    const mimeType = (file.type || "").toLowerCase();
    return mimeType.startsWith("image/");
  });
}


const MyRte = ({ rteRef, editable = false, contentValue, ...props }) => {
  useEffect(() => {
    if (rteRef.current?.editor) {
      rteRef.current.editor.commands.setContent(contentValue);
    }
  }, [contentValue]);

  const handleNewImageFiles = useCallback(
    (files, insertPosition) => {
      if (!rteRef.current?.editor) {
        return;
      }

      // Use the FileReader API to read each image file as a data URL
      const reader = new FileReader();
      reader.onload = () => {
        const dataUrl = reader.result;

        // Insert the image into the editor content with the data URL as the src attribute
        rteRef.current.editor.chain().focus().setImage({ src: dataUrl }).run();
      };

      // Read each image file as a data URL
      files.forEach((file) => {
        reader.readAsDataURL(file);
      });
    },
    []
  );

  const handleDrop = useCallback(
    (view, event, _slice, _moved) => {
      if (!(event instanceof DragEvent) || !event.dataTransfer) {
        return false;
      }

      const imageFiles = fileListToImageFiles(event.dataTransfer.files);
      if (imageFiles.length > 0) {
        const insertPosition = view.posAtCoords({
          left: event.clientX,
          top: event.clientY,
        })?.pos;

        handleNewImageFiles(imageFiles, insertPosition);

        event.preventDefault();
        return true;
      }

      return false;
    },
    [handleNewImageFiles]
  );

  const handlePaste = useCallback(
    (_view, event, _slice) => {
      if (!event.clipboardData) {
        return false;
      }

      const pastedImageFiles = fileListToImageFiles(
        event.clipboardData.files
      );
      if (pastedImageFiles.length > 0) {
        handleNewImageFiles(pastedImageFiles);
        return true;
      }

      return false;
    },
    [handleNewImageFiles]
  );

  return (
    <Box sx={{
      "& .ProseMirror": {
        "& h1, & h2, & h3, & h4, & h5, & h6": {
          scrollMarginTop: 50,
        },
      },
    }}>
      <RichTextEditor
        {...props}
        editable={editable}
        ref={rteRef}
        extensions={extensions}
        renderControls={() => (
          <MyRteMenus />
        )}
        editorProps={{
          attributes: {
            class: "my-rte"
          },
          handleDrop,
          handlePaste,
        }}
      >
        {() => (
          <>
            <LinkBubbleMenu />
            <TableBubbleMenu />
          </>
        )}
      </RichTextEditor>

      <Button onClick={() => console.log(rteRef.current?.editor?.getHTML())}>
        Log HTML
      </Button>
    </Box>
  )
}

export default MyRte